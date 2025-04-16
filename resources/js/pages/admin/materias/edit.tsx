import InputError from '@/components/input-error'
import { TextArea } from '@/components/text-area'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Materia } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

interface PageProps {
  materia: Materia
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Editar materia',
    href: '/admin/materias/create'
  }
]

export default function Page({ materia }: PageProps) {
  const { data, setData, put, processing, errors, reset } = useForm<Required<any>>({
    nombre: materia.nombre,
    descripcion: materia.descripcion
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    put(route('admin.materias.update', materia.id), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Editar Materia' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/materias' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Editar Materia</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit}>
          <div className='space-y-6'>
            {/* Nombre de Materia */}
            <div>
              <Label htmlFor='nombre'>Nombre</Label>
              <Input id='nombre' name='nombre' value={data.nombre} onChange={(e) => setData('nombre', e.target.value)} autoFocus />
              <InputError message={errors.nombre} />
            </div>

            {/* Descripción */}
            <div>
              <Label htmlFor='descripcion'>Descripción</Label>
              <TextArea id='descripcion' name='descripcion' value={data.descripcion} onChange={(e) => setData('descripcion', e.target.value)} />
              <InputError message={errors.descripcion} />
            </div>

            {/* Botón de Envío */}
            <div className='flex items-center'>
              <Button className='w-full' disabled={processing}>
                {processing && <LoaderCircle className='h-4 w-4 animate-spin' />}
                Editar
              </Button>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
