import FlashMesssage from '@/components/flash'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import { getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, PaginatedResponse, ResourcePageProps, User } from '@/types'
import { Head, Link } from '@inertiajs/react'

type PageProps = Omit<ResourcePageProps<User>, 'data'> & {
  users: PaginatedResponse<User>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuarios',
    href: '/admin/users'
  }
]

const columns: Column<User>[] = [
  {
    accessorKey: 'id',
    header: 'ID'
  },
  {
    accessorKey: 'name',
    header: 'Nombre'
  },
  {
    accessorKey: 'email',
    header: 'Email'
  },
  {
    accessorKey: 'created_at',
    header: 'Fecha de Creación',
    renderCell: (user) => formatDateTime(user.created_at)
  },
  {
    accessorKey: 'actions',
    header: 'Acciones',
    renderCell: (user) => (
      <div className='flex flex-wrap gap-4'>
        <Link
          href={route('users.show', user.id)}
          className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
        >
          Ver
        </Link>

        <Link
          href={route('users.edit', user.id)}
          className='inline-flex items-center rounded border border-green-500 px-3 py-1 text-sm text-green-500 hover:bg-green-50 hover:text-green-700'
        >
          Editar
        </Link>

        <Link
          href={route('users.destroy', user.id)}
          method='delete'
          className='inline-flex items-center rounded border border-red-500 px-3 py-1 text-sm text-red-500 hover:bg-red-50 hover:text-red-700'
        >
          Eliminar
        </Link>
      </div>
    )
  }
]

export default function Page({ users, flash }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Usuarios' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Usuarios</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='users/create' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            Crear usuario
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
            {users.data.map((user) => (
              <tr key={user.id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                    {'renderCell' in column ? column.renderCell?.(user) : String(getNestedValue(user, column.accessorKey))}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>

        {/* Paginación básica */}
        <div className='mt-4 flex justify-between'>
          <span>
            Página {users.current_page} de {users.last_page}
          </span>
          <div className='space-x-2'>
            {users.prev_page_url && <Link href={users.prev_page_url}>Anterior</Link>}
            {users.next_page_url && <Link href={users.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
