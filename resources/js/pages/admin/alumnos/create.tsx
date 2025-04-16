import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Radio, RadioGroup } from '@/components/ui/radio'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, Seccion, User } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

interface PageProps {
  users: User[]
  secciones: Seccion[]
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Crear Alumno',
    href: '/admin/alumnos/create'
  }
]

export default function Page({ users, secciones }: PageProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    user_id: '',
    seccion_id: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.alumnos.store'), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Crear Alumno' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/alumnos' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Crear Alumno</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit}>
          <div className='space-y-6'>
            {/* Selección de Usuario */}
            <div>
              <Label htmlFor='user_id'>Seleccione un usuario</Label>
              <Select value={data.user_id} onValueChange={(value) => setData('user_id', value)}>
                <SelectTrigger id='user_id' name='user_id'>
                  <SelectValue placeholder='Seleccione un usuario' />
                </SelectTrigger>
                <SelectContent>
                  {users.map((user) => (
                    <SelectItem key={user.id} value={user.id.toString()}>
                      {`${user?.perfil?.nombre} ${user?.perfil?.apellido}, DNI: ${user?.perfil?.DNI}`}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <InputError message={errors.user_id} />
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
                Crear
              </Button>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
