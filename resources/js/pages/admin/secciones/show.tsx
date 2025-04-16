import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Seccion } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

interface PageProps {
  seccion: Seccion
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver Sección',
    href: '/admin/secciones/show'
  }
]

export default function CreateSeccionPage({ seccion }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Sección' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/secciones' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Sección</h1>
        </div>

        {/* Selección de Sección */}
        <div>
          <Label htmlFor='nombre'>Sección</Label>
          <Input id='nombre' name='nombre' type='text' value={seccion.nombre} />
        </div>

        {/* Selección de Grado */}
        <div>
          <Label htmlFor='grado'>Grado Nivel</Label>
          <Input id='grado' name='grado' type='text' value={seccion.grado.grado + ' DE ' + seccion.grado.nivel} />
        </div>
      </div>
    </AppLayout>
  )
}
