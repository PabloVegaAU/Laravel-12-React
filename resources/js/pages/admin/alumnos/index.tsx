import FlashMesssage from '@/components/flash'
import { Button } from '@/components/ui/button'
import Table from '@/components/ui/table'
import AppLayout from '@/layouts/app-layout'
import { formatDateTime } from '@/lib/formatters'
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

export default function Page({ alumnos, flash }: PageProps) {
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
      accessorKey: 'user.perfil.dni',
      header: 'DNI'
    },
    {
      accessorKey: 'user.email',
      header: 'EMAIL'
    },
    {
      accessorKey: 'aula_actual.aula.grado.nombre',
      header: 'GRADO'
    },
    {
      accessorKey: 'aula_actual.aula.seccion.nombre',
      header: 'SECCIÓN'
    },
    {
      accessorKey: 'created_at',
      header: 'Fecha de Creación',
      renderCell: (alumno) => formatDateTime(alumno.created_at)
    },
    {
      accessorKey: 'actions',
      header: 'Acciones',
      renderCell: (alumno) => (
        <div className='flex flex-wrap gap-4'>
          <Button asChild variant='outline-info' size='sm'>
            <Link href={route('admin.alumnos.show', alumno.user_id)}>Ver</Link>
          </Button>

          <Button asChild variant='outline-warning' size='sm'>
            <Link href={route('admin.alumnos.edit', alumno.user_id)}>Editar</Link>
          </Button>

          <Button asChild variant='outline-destructive' size='sm'>
            <Link href={route('admin.alumnos.destroy', alumno.user_id)} method='delete'>
              Eliminar
            </Link>
          </Button>
        </div>
      )
    }
  ]

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Alumnos' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1 className='text-2xl font-bold'>Listado de Alumnos</h1>

        <div>
          <FlashMesssage flash={flash} />

          <Link href='alumnos/create'>
            <Button variant='outline-info'> Agregar Alumno</Button>
          </Link>
        </div>

        <Table data={alumnos} columns={columns} />
      </div>
    </AppLayout>
  )
}
