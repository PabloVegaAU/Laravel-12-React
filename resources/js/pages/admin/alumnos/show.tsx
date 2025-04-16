import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { Alumno, BreadcrumbItem } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

interface PageProps {
  alumno: Alumno
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver Alumno',
    href: '/admin/alumnos/show'
  }
]

export default function Page({ alumno }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Alumno' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/alumnos' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Alumno</h1>
        </div>

        <div className='space-y-6'>
          {/* Selección de Usuario */}
          <div>
            <Label htmlFor='user_id'>Usuario</Label>
            <Input value={alumno.user.name} />
          </div>

          {/* Selección de Secciones */}
          <div>
            <Label htmlFor='user_id'>Sección y grado</Label>
            <Input value={`Sección: ${alumno.seccion.nombre}, Año: ${alumno.seccion.grado.grado}, Nivel: ${alumno.seccion.grado.nivel}`} />
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
