import FlashMesssage from '@/components/flash'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import { getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, Docente, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'

type PageProps = Omit<ResourcePageProps<Docente>, 'data'> & {
  docentes: PaginatedResponse<Docente>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Docentes',
    href: '/admin/docentes'
  }
]

const columns: Column<Docente>[] = [
  {
    accessorKey: 'user_id',
    header: 'ID'
  },
  {
    accessorKey: 'user.name',
    header: 'NOMBRE'
  },
  {
    accessorKey: 'user.perfil.DNI',
    header: 'DNI'
  },
  {
    accessorKey: 'user.email',
    header: 'EMAIL'
  },
  {
    accessorKey: 'created_at',
    header: 'Fecha de Creación',
    renderCell: (docente) => formatDateTime(docente.created_at)
  }
]

export default function Page({ docentes, flash }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Docentes' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Docentes</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='docentes/create' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            Crear Docente
          </Link>
        </div>

        <table className='min-w-full divide-y divide-gray-200 border border-gray-300'>
          <thead className='bg-gray-50'>
            <tr>
              {columns.map((column) => (
                <th key={column.accessorKey} className='px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-700 uppercase'>
                  {column.header}
                </th>
              ))}
              <th />
            </tr>
          </thead>
          <tbody className='divide-y divide-gray-200 bg-white'>
            {docentes.data?.map((docente) => (
              <tr key={docente.user_id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                    {'renderCell' in column ? column.renderCell?.(docente) : String(getNestedValue(docente, column.accessorKey))}
                  </td>
                ))}
                <td className='py-1'>
                  <div className='flex flex-wrap gap-4'>
                    <Link
                      href={route('admin.docentes.show', docente.user_id)}
                      className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
                    >
                      Ver
                    </Link>

                    <Link
                      href={route('admin.docentes.edit', docente.user_id)}
                      className='inline-flex items-center rounded border border-green-500 px-3 py-1 text-sm text-green-500 hover:bg-green-50 hover:text-green-700'
                    >
                      Editar
                    </Link>

                    <Link
                      href={route('admin.docentes.destroy', docente.user_id)}
                      method='delete'
                      className='inline-flex items-center rounded border border-red-500 px-3 py-1 text-sm text-red-500 hover:bg-red-50 hover:text-red-700'
                    >
                      Eliminar
                    </Link>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>

        {/* Paginación básica */}
        <div className='mt-4 flex justify-between'>
          <span>
            Página {docentes.current_page} de {docentes.last_page}
          </span>
          <div className='space-x-2'>
            {docentes.prev_page_url && <Link href={docentes.prev_page_url}>Anterior</Link>}
            {docentes.next_page_url && <Link href={docentes.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
