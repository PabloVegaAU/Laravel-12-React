import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem } from '@/types'
import { Head } from '@inertiajs/react'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Inicio',
    href: '/admin'
  }
]

export default function Page() {
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Admin' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <h1>Sistema Web de Gestion de tareas Escolares</h1>
        <p>¡Bienvenido al panel de administracion!</p>
      </div>
    </AppLayout>
  )
}
