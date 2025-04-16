import FlashMesssage from '@/components/flash'
import AppLayout from '@/layouts/app-layout'
import { getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, Grado, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'

type PageProps = Omit<ResourcePageProps<Grado>, 'data'> & {
  grados: PaginatedResponse<Grado>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Grados',
    href: '/admin/grados'
  }
]

const columns: Column<Grado>[] = [
  {
    accessorKey: 'id',
    header: 'ID'
  },
  {
    accessorKey: 'grado',
    header: 'GRADO'
  },
  {
    accessorKey: 'nivel',
    header: 'NIVEL'
  },
  {
    accessorKey: 'acciones',
    header: '',
    renderCell: (grado) => (
      <div className='flex flex-wrap gap-4'>
        <Link
          href={route('admin.grados.show', grado.id)}
          className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
        >
          Ver
        </Link>

        <Link
          href={route('admin.grados.destroy', grado.id)}
          method='delete'
          className='inline-flex items-center rounded border border-red-500 px-3 py-1 text-sm text-red-500 hover:bg-red-50 hover:text-red-700'
        >
          Eliminar
        </Link>
      </div>
    )
  }
]

export default function Page({ grados, flash }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Grados' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Grados</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='grados/create' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            Crear Grado
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
            {grados.data?.map((grado) => (
              <tr key={grado.id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                    {'renderCell' in column ? column.renderCell?.(grado) : String(getNestedValue(grado, column.accessorKey))}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>

        {/* Paginación básica */}
        <div className='mt-4 flex justify-between'>
          <span>
            Página {grados.current_page} de {grados.last_page}
          </span>
          <div className='space-x-2'>
            {grados.prev_page_url && <Link href={grados.prev_page_url}>Anterior</Link>}
            {grados.next_page_url && <Link href={grados.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
