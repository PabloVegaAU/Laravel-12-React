import { TextArea } from '@/components/text-area'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Materia } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

interface PageProps {
  materia: Materia
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver materia',
    href: '/admin/materias/show'
  }
]

export default function Page({ materia }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Materia' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/materias' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Materia</h1>
        </div>

        <div className='space-y-6'>
          {/* Nombre de Materia */}
          <div>
            <Label htmlFor='nombre'>Nombre</Label>
            <Input id='nombre' name='nombre' value={materia.nombre} />
          </div>

          {/* Descripción de Materia*/}
          <div>
            <Label htmlFor='descripcion'>Descripción</Label>
            <TextArea id='descripcion' name='descripcion' value={materia.descripcion} />
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
