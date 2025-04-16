import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import AppLayout from '@/layouts/app-layout'
import { getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, Grado, PaginatedResponse, ResourcePageProps } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'
import FormCreate from './components/form-create'

type PageProps = Omit<ResourcePageProps<Grado>, 'data'> & {
  grados: PaginatedResponse<Grado>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Grados',
    href: '/admin/grados'
  }
]

export default function Page({ grados, flash }: PageProps) {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false)

  const columns: Column<Grado>[] = [
    {
      accessorKey: 'id',
      header: 'ID'
    },
    {
      accessorKey: 'nombre',
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
          <Button asChild variant='delete' size='sm'>
            <Link href={route('admin.grados.destroy', grado.id)} method='delete'>
              Eliminar
            </Link>
          </Button>
        </div>
      )
    }
  ]

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Grados' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Grados</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen}>
            <DialogTrigger asChild>
              <Button className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>Agregar grado</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogTitle>Agregar grado</DialogTitle>
              <DialogDescription>Complete el formulario para agregar un nueva grado.</DialogDescription>
              <FormCreate
                onFormSuccess={() => {
                  setIsCreateModalOpen(false) // Cierra el modal
                }}
              />
            </DialogContent>
          </Dialog>
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
