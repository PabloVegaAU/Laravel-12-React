import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import Table from '@/components/ui/table'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import type { BreadcrumbItem, Column, PaginatedResponse, ResourcePageProps, User } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'
import FormCreate from './_components/formCreate'
import FormEdit from './_components/formEdit' // Importa el nuevo componente

type PageProps = Omit<ResourcePageProps<User>, 'data'> & {
  users: PaginatedResponse<User>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Usuarios',
    href: '/admin/users'
  }
]

export default function Page({ users, flash }: PageProps) {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false)
  const [userId, setUserId] = useState<number | null>(null)

  // Función para cerrar el modal de edición y resetear el usuario
  const closeEditModal = () => {
    setUserId(null)
  }

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
            href={route('admin.users.show', user.id)}
            className='inline-flex items-center rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-700'
          >
            Ver
          </Link>

          {/* Modifica el enlace de Editar para abrir el modal */}
          <Button
            variant='outline' // Usa un estilo de botón similar
            size='sm' // Usa un tamaño de botón similar
            className='inline-flex items-center rounded border border-green-500 px-3 py-1 text-sm text-green-500 hover:bg-green-50 hover:text-green-700'
            onClick={() => setUserId(user.id)}
          >
            Editar
          </Button>

          <Link
            href={route('admin.users.destroy', user.id)}
            method='delete'
            className='inline-flex items-center rounded border border-red-500 px-3 py-1 text-sm text-red-500 hover:bg-red-50 hover:text-red-700'
          >
            Eliminar
          </Link>
        </div>
      )
    }
  ]

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Usuarios' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Usuarios</h1>

        <div>
          <FlashMesssage flash={flash} />

          {/* Modal de Creación */}
          <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen}>
            <DialogTrigger asChild>
              <Button className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>Agregar usuario</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogTitle>Crear Usuario</DialogTitle>
              <DialogDescription>Complete el formulario para crear un nuevo usuario.</DialogDescription>
              <FormCreate
                onFormSuccess={() => {
                  setIsCreateModalOpen(false) // Cierra el modal
                }}
              />
            </DialogContent>
          </Dialog>

          {/* Modal de Edición */}
          {userId && (
            <Dialog open={!!userId} onOpenChange={() => setUserId(null)}>
              <DialogContent>
                <DialogTitle>Editar Usuario</DialogTitle>
                <DialogDescription>Complete el formulario para editar el usuario.</DialogDescription>
                <FormEdit
                  userId={userId}
                  onFormSuccess={closeEditModal} // Pasa la función para cerrar el modal
                />
              </DialogContent>
            </Dialog>
          )}
        </div>

        <Table data={users} columns={columns} />
      </div>
    </AppLayout>
  )
}
