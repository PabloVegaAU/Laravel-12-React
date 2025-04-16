import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Docente } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

interface PageProps {
  docente: Docente
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver docente',
    href: '/admin/docentes/show'
  }
]

export default function Page({ docente }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Docente' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/docentes' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Docente</h1>
        </div>
        <div className='space-y-6'>
          {/* Selección de Usuario */}
          <div>
            <Label htmlFor='user_id'>Nombre</Label>
            <Input id='user_id' type='text' value={docente?.user?.name} />
          </div>

          {/* Selección de Materias */}
          <div>
            <Label htmlFor='materias'>Materias:</Label>
            <div className='grid grid-cols-2 gap-2'>
              {docente.materias.map((materia) => (
                <div key={materia.id} className='flex items-center space-x-2'>
                  <Checkbox id={`materia-${materia.id}`} checked={true} />
                  <Label htmlFor={`materia-${materia.id}`}>{materia.nombre}</Label>
                </div>
              ))}
            </div>
          </div>

          {/* Selección de Secciones */}
          <div>
            <Label htmlFor='secciones'>Secciones:</Label>
            <div className='grid grid-cols-2 gap-2'>
              {docente.secciones.map((seccion) => (
                <div key={seccion.id} className='flex items-center space-x-2'>
                  <Checkbox id={`seccion-${seccion.id}`} checked={true} />
                  <Label htmlFor={`seccion-${seccion.id}`}>
                    {`Sección: ${seccion.nombre}, Año: ${seccion.grado.grado}, Nivel: ${seccion.grado.nivel}`}
                  </Label>
                </div>
              ))}
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
