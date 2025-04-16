import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Crear usuario',
    href: '/admin/users/create'
  }
]

export default function Page() {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    email: '',
    password: '',
    name: '',
    apellido: '',
    fecha: '',
    dni: '',
    edad: '',
    sexo: 'm',
    direccion: '',
    distrito: '',
    rol: [] as number[]
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.users.store'), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Usuarios' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/users' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Crear usuario</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit}>
          <div className='space-y-6'>
            <div className='flex gap-4'>
              <div className='flex-1'>
                <Label htmlFor='email'>Correo Electronico</Label>
                <Input
                  id='email'
                  type='email'
                  name='email'
                  autoComplete='email'
                  value={data.email}
                  autoFocus
                  onChange={(e) => setData('email', e.target.value)}
                />
                <InputError message={errors.email} />
              </div>

              <div className='flex-1'>
                <Label htmlFor='password'>Contraseña</Label>
                <Input
                  id='password'
                  type='password'
                  name='password'
                  autoComplete='new-password'
                  value={data.password}
                  autoFocus
                  onChange={(e) => setData('password', e.target.value)}
                />
                <InputError message={errors.password} />
              </div>
            </div>

            <div className='flex gap-4'>
              <div className='flex-1'>
                <Label htmlFor='name'>Nombres</Label>
                <Input
                  id='name'
                  type='name'
                  name='name'
                  autoComplete='current-name'
                  value={data.name}
                  autoFocus
                  onChange={(e) => setData('name', e.target.value)}
                />
                <InputError message={errors.name} />
              </div>

              <div className='flex-1'>
                <Label htmlFor='apellido'>Apellidos</Label>
                <Input
                  id='apellido'
                  type='text'
                  name='apellido'
                  value={data.apellido}
                  autoFocus
                  onChange={(e) => setData('apellido', e.target.value)}
                />
                <InputError message={errors.apellido} />
              </div>
            </div>

            <div className='flex gap-4'>
              <div className='flex-1'>
                <Label htmlFor='fecha'>Fecha</Label>
                <Input id='fecha' type='date' name='fecha' value={data.fecha} autoFocus onChange={(e) => setData('fecha', e.target.value)} />
                <InputError message={errors.fecha} />
              </div>

              <div className='flex-1'>
                <Label htmlFor='dni'>DNI</Label>
                <Input id='dni' type='number' name='dni' value={data.dni} autoFocus onChange={(e) => setData('dni', e.target.value)} />
                <InputError message={errors.dni} />
              </div>

              <div className='flex-1'>
                <Label htmlFor='edad'>Edad</Label>
                <Input id='edad' type='text' name='edad' value={data.edad} autoFocus onChange={(e) => setData('edad', e.target.value)} />
                <InputError message={errors.edad} />
              </div>

              <div className='flex-1'>
                <Label htmlFor='sexo'>Sexo</Label>
                <Select value={data.sexo} onValueChange={(e) => setData('sexo', e)}>
                  <SelectTrigger id='sexo' name='sexo'>
                    <SelectValue />
                  </SelectTrigger>
                  <SelectContent>
                    <SelectItem value='m'>Masculino</SelectItem>
                    <SelectItem value='f'>Femenino</SelectItem>
                  </SelectContent>
                </Select>
                <InputError message={errors.sexo} />
              </div>
            </div>

            <div className='flex gap-4'>
              <div className='flex-1'>
                <Label htmlFor='direccion'>Direccion</Label>
                <Input
                  id='direccion'
                  type='text'
                  name='direccion'
                  value={data.direccion}
                  autoFocus
                  onChange={(e) => setData('direccion', e.target.value)}
                />
                <InputError message={errors.direccion} />
              </div>
              <div className='flex-1'>
                <Label htmlFor='distrito'>Distrito</Label>
                <Input
                  id='distrito'
                  type='text'
                  name='distrito'
                  value={data.distrito}
                  autoFocus
                  onChange={(e) => setData('distrito', e.target.value)}
                />
                <InputError message={errors.distrito} />
              </div>
            </div>

            <div>
              <div className='flex items-center gap-4'>
                <Label htmlFor='rol'>Rol Admin</Label>
                <Checkbox
                  id='rol_id'
                  name='rol_id'
                  checked={data.rol.includes(1)}
                  onCheckedChange={(checked) => setData('rol', checked ? [1] : [])}
                />
              </div>
              <InputError message={errors.rol} />
            </div>

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
