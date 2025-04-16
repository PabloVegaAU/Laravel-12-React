import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import { Dialog, DialogContent, DialogDescription, DialogTitle, DialogTrigger } from '@/components/ui/dialog'
import AppLayout from '@/layouts/app-layout'
import { getNestedValue } from '@/lib/utils'
import type { BreadcrumbItem, Column, PaginatedResponse, ResourcePageProps, Seccion } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { useState } from 'react'
import FormCreate from './components/formCreate'

type PageProps = Omit<ResourcePageProps<Seccion>, 'data'> & {
  secciones: PaginatedResponse<Seccion>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Secciones',
    href: '/admin/seccions'
  }
]

export default function Page({ secciones, flash }: PageProps) {
  const [isCreateModalOpen, setIsCreateModalOpen] = useState(false)

  const columns: Column<Seccion>[] = [
    {
      accessorKey: 'id',
      header: 'ID'
    },
    {
      accessorKey: 'nombre',
      header: 'NOMBRE'
    },
    {
      accessorKey: 'acciones',
      header: '',
      renderCell: (seccion) => (
        <div className='flex flex-wrap gap-4'>
          <Button asChild variant='delete' size='sm'>
            <Link href={route('admin.secciones.destroy', seccion.id)} method='delete'>
              Eliminar
            </Link>
          </Button>
        </div>
      )
    }
  ]

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Secciones' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Secciones</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Dialog open={isCreateModalOpen} onOpenChange={setIsCreateModalOpen}>
            <DialogTrigger asChild>
              <Button className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>Agregar sección</Button>
            </DialogTrigger>
            <DialogContent>
              <DialogTitle>Agregar sección</DialogTitle>
              <DialogDescription>Complete el formulario para agregar un nueva sesión.</DialogDescription>
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
            {secciones.data?.map((seccion) => (
              <tr key={seccion.id}>
                {columns.map((column) => (
                  <td key={column.accessorKey} className='px-6 py-4 whitespace-nowrap'>
                    {'renderCell' in column ? column.renderCell?.(seccion) : String(getNestedValue(seccion, column.accessorKey))}
                  </td>
                ))}
              </tr>
            ))}
          </tbody>
        </table>

        {/* Paginación básica */}
        <div className='mt-4 flex justify-between'>
          <span>
            Página {secciones.current_page} de {secciones.last_page}
          </span>
          <div className='space-x-2'>
            {secciones.prev_page_url && <Link href={secciones.prev_page_url}>Anterior</Link>}
            {secciones.next_page_url && <Link href={secciones.next_page_url}>Siguiente</Link>}
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
