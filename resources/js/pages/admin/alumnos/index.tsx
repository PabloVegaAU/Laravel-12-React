import FlashMesssage from '@/components/flash'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import { getNestedValue } from '@/lib/utils'
import type { Alumno, BreadcrumbItem, Column, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'

type PageProps = Omit<ResourcePageProps<Alumno>, 'data'> & {
  alumnos: PaginatedResponse<Alumno>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Alumnos',
    href: '/admin/alumnos'
  }
]

const columns: Column<Alumno>[] = [
  {
    accessorKey: 'user_id',
    header: 'ID'
  },
  {
    accessorKey: 'user.perfil.nombre',
    header: 'NOMBRE'
  },
  {
    accessorKey: 'user.perfil.apellido',
    header: 'APELLIDO'
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
    accessorKey: 'seccion.grado.grado',
    header: 'GRADO'
  },
  {
    accessorKey: 'seccion.nombre',
    header: 'SECCIÓN'
  },
  {
    accessorKey: 'created_at',
    header: 'Fecha de Creación',
    renderCell: (alumno) => formatDateTime(alumno.created_at)
  }
]

export default function Page({ alumnos, flash }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Alumnos' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Alumnos</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='alumnos/create' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            Crear Alumno
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
            {alumnos.data?.map((alumno) => (
              <tr key={alumno.user_id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                    {'renderCell' in column ? column.renderCell?.(alumno) : String(getNestedValue(alumno, column.accessorKey))}
                  </td>
                ))}
                <td className='py-1'>
                  <div className='flex flex-wrap gap-4'>
                    <Link
                      href={route('admin.alumnos.show', alumno.user_id)}
                      className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
                    >
                      Ver
                    </Link>

                    <Link
                      href={route('admin.alumnos.edit', alumno.user_id)}
                      className='inline-flex items-center rounded border border-green-500 px-3 py-1 text-sm text-green-500 hover:bg-green-50 hover:text-green-700'
                    >
                      Editar
                    </Link>

                    <Link
                      href={route('admin.alumnos.destroy', alumno.user_id)}
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
            Página {alumnos.current_page} de {alumnos.last_page}
          </span>
          <div className='space-x-2'>
            {alumnos.prev_page_url && <Link href={alumnos.prev_page_url}>Anterior</Link>}
            {alumnos.next_page_url && <Link href={alumnos.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
