import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import Table from '@/components/ui/table'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
import type { BreadcrumbItem, Column, Docente, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'
import FormCreate from './components/form-create'

type PageProps = Omit<ResourcePageProps<Docente>, 'data'> & {
  docentes: PaginatedResponse<Docente>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Docentes',
    href: '/admin/docentes'
  }
]

export default function Page({ docentes, flash }: PageProps) {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false)

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
      accessorKey: 'user.perfil.dni',
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
    },
    {
      accessorKey: 'actions',
      header: 'Acciones',
      renderCell: (docente) => (
        <div className='flex flex-wrap gap-4'>
          <Button asChild variant='outline-info' size='sm'>
            <Link href={route('admin.docentes.show', docente.user_id)}>Ver</Link>
          </Button>

          <Button asChild variant='outline-warning' size='sm'>
            <Link href={route('admin.docentes.edit', docente.user_id)}>Editar</Link>
          </Button>

          <Button asChild variant='outline-destructive' size='sm'>
            <Link href={route('admin.docentes.destroy', docente.user_id)} method='delete'>
              Eliminar
            </Link>
          </Button>
        </div>
      )
    }
  ]

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Docentes' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Docentes</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen}>
            <DialogTrigger asChild>
              <Button variant='outline-info'>Agregar Docente</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogTitle>Agregar Docente</DialogTitle>
              <DialogDescription>Complete el formulario para agregar un nuevo docente.</DialogDescription>
              <FormCreate
                onFormSuccess={() => {
                  setIsCreateModalOpen(false)
                }}
              />
            </DialogContent>
          </Dialog>
        </div>

        <Table data={docentes} columns={columns} />
      </div>
    </AppLayout>
  )
}
