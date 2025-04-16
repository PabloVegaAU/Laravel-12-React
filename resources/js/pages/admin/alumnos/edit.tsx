import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Radio, RadioGroup } from '@/components/ui/radio'
import AppLayout from '@/layouts/app-layout'
import type { Alumno, BreadcrumbItem, Seccion } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

interface PageProps {
  alumno: Alumno
  secciones: Seccion[]
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Editar Alumno',
    href: '/admin/alumnos/edit'
  }
]

export default function Page({ alumno, secciones }: PageProps) {
  const { data, setData, put, processing, errors, reset } = useForm<Required<any>>({
    seccion_id: alumno.seccion_id.toString()
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    put(route('admin.alumnos.update', alumno.user_id), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Editar Alumno' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/alumnos' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Editar Alumno</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit}>
          <div className='space-y-6'>
            {/* Selección de Usuario */}
            <div>
              <Label htmlFor='user_id'>Usuario</Label>
              <Input value={alumno.user.name} />
            </div>

            {/* Selección de Secciones */}
            <div>
              <p className='font-semibold'>Secciones:</p>
              <RadioGroup value={data.seccion_id} onValueChange={(id: string) => setData('seccion_id', id)}>
                {secciones.map((seccion) => (
                  <div key={seccion.id} className='flex items-center space-x-2'>
                    <Radio id={`seccion-${seccion.id}`} value={seccion.id.toString()} />
                    <Label htmlFor={`seccion-${seccion.id}`}>
                      {`Sección: ${seccion.nombre}, Año: ${seccion.grado.grado}, Nivel: ${seccion.grado.nivel}`}
                    </Label>
                  </div>
                ))}
              </RadioGroup>
              <InputError message={errors.secciones} />
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
