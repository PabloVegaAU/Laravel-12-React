import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Grado } from '@/types'
import { Head, Link } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

interface PageProps {
  grado: Grado
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver grado',
    href: '/admin/grados/show'
  }
]

export default function Page({ grado }: PageProps) {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Grado' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/grados' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Grado</h1>
        </div>

        <div className='space-y-6'>
          <div>
            <Label htmlFor='grado'>Grado</Label>
            <Input id='grado' name='grado' value={grado.grado} />
          </div>

          <div>
            <Label htmlFor='nivel'>Nivel</Label>
            <Input id='nivel' name='nivel' value={grado.nivel} />
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
