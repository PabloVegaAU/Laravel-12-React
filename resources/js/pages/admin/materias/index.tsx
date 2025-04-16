import FlashMesssage from '@/components/flash'
import AppLayout from '@/layouts/app-layout'
import { cn, getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, Materia, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'

type PageProps = Omit<ResourcePageProps<Materia>, 'data'> & {
  materias: PaginatedResponse<Materia>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Materias',
    href: '/admin/materias'
  }
]

const columns: Column<Materia>[] = [
  {
    accessorKey: 'id',
    header: 'ID'
  },
  {
    accessorKey: 'nombre',
    header: 'NOMBRE'
  },
  {
    accessorKey: 'descripcion',
    header: 'DESCRIPCIÓN'
  },
  {
    accessorKey: 'acciones',
    header: '',
    renderCell: (materia) => (
      <div className='flex flex-wrap gap-4'>
        <Link
          href={route('admin.materias.show', materia.id)}
          className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
        >
          Ver
        </Link>

        <Link
          href={route('admin.materias.edit', materia.id)}
          className='inline-flex items-center rounded border border-green-500 px-3 py-1 text-sm text-green-500 hover:bg-green-50 hover:text-green-700'
        >
          Editar
        </Link>

        <Link
          href={route('admin.materias.destroy', materia.id)}
          method='delete'
          className='inline-flex items-center rounded border border-red-500 px-3 py-1 text-sm text-red-500 hover:bg-red-50 hover:text-red-700'
        >
          Eliminar
        </Link>
      </div>
    )
  }
]

export default function Page({ materias, flash }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Materias' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Materias</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='materias/create' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            Crear Materia
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
            {materias.data?.map((materia) => (
              <tr key={materia.id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className={cn('max-w-2xl px-6 py-4', column.accessorKey === 'descripcion' ? 'truncate' : '')}>
                    {'renderCell' in column ? column.renderCell?.(materia) : String(getNestedValue(materia, column.accessorKey))}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>

        {/* Paginación básica */}
        <div className='mt-4 flex justify-between'>
          <span>
            Página {materias.current_page} de {materias.last_page}
          </span>
          <div className='space-x-2'>
            {materias.prev_page_url && <Link href={materias.prev_page_url}>Anterior</Link>}
            {materias.next_page_url && <Link href={materias.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
