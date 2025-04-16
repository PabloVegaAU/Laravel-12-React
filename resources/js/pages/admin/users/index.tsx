import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import Table from '@/components/ui/table'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import type { BreadcrumbItem, Column, PaginatedResponse, ResourcePageProps, User } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'
import FormCreate from './components/form-create'
import FormEdit from './components/form-edit' // Importa el nuevo componente

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
  const [update, setUpdate] = useState(false)
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
          <Button
            variant='outline-info'
            size='sm'
            onClick={() => {
              setUpdate(false)
              setUserId(user.id)
            }}
          >
            Ver
          </Button>

          <Button
            variant='outline-warning'
            size='sm'
            onClick={() => {
              setUpdate(true)
              setUserId(user.id)
            }}
          >
            Editar
          </Button>

          <Button asChild variant='outline-destructive' size='sm'>
            <Link href={route('admin.users.destroy', user.id)} method='delete'>
              Eliminar
            </Link>
          </Button>
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

          <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen}>
            <DialogTrigger asChild>
              <Button variant='outline-info'>Agregar usuario</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogTitle>Agregar usuario</DialogTitle>
              <DialogDescription>Complete el formulario para agregar un nuevo usuario.</DialogDescription>
              <FormCreate
                onFormSuccess={() => {
                  setIsCreateModalOpen(false) // Cierra el modal
                }}
              />
            </DialogContent>
          </Dialog>

          {userId && (
            <Dialog open={!!userId} onOpenChange={() => setUserId(null)}>
              <DialogContent>
                <DialogTitle>{update ? 'Editar' : 'Ver'} usuario</DialogTitle>
                {update && <DialogDescription>Complete el formulario para editar el usuario.</DialogDescription>}
                <FormEdit update={update} userId={userId} onFormSuccess={closeEditModal} />
              </DialogContent>
            </Dialog>
          )}
        </div>

        <Table data={users} columns={columns} />
      </div>
    </AppLayout>
  )
}
