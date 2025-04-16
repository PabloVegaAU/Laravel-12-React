import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem, User } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'

export default function Page({ user }: { user: User }) {
  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: 'Ver usuario',
      href: `/admin/users/${user.id}/show`
    }
  ]

  const { data } = useForm<Required<any>>({
    email: user.email,
    name: user.perfil?.nombre,
    apellido: user.perfil?.apellido,
    fecha: user.perfil?.fecha_nac,
    dni: user.perfil?.dni,
    edad: user.perfil?.edad,
    sexo: user.perfil?.sexo,
    direccion: user.perfil?.direccion,
    distrito: user.perfil?.distrito
  })

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Usuarios' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/users' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver usuario</h1>
        </div>

        <div className='space-y-6'>
          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='email'>Correo Electronico</Label>
              <Input id='email' type='email' name='email' autoComplete='email' value={data.email} readOnly />
            </div>
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='name'>Nombres</Label>
              <Input id='name' type='name' name='name' autoComplete='current-name' value={data.name} readOnly />
            </div>

            <div className='flex-1'>
              <Label htmlFor='apellido'>Apellidos</Label>
              <Input id='apellido' type='text' name='apellido' value={data.apellido} readOnly />
            </div>
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='fecha'>Fecha</Label>
              <Input id='fecha' type='date' name='fecha' value={data.fecha} readOnly />
            </div>

            <div className='flex-1'>
              <Label htmlFor='dni'>DNI</Label>
              <Input id='dni' type='number' name='dni' value={data.dni} readOnly />
            </div>

            <div className='flex-1'>
              <Label htmlFor='edad'>Edad</Label>
              <Input id='edad' type='text' name='edad' value={data.edad} readOnly />
            </div>

            <div className='flex-1'>
              <Label htmlFor='sexo'>Sexo</Label>
              <Select value={data.sexo} disabled>
                <SelectTrigger id='sexo' name='sexo'>
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  <SelectItem value='m'>Masculino</SelectItem>
                  <SelectItem value='f'>Femenino</SelectItem>
                </SelectContent>
              </Select>
            </div>
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='direccion'>Direccion</Label>
              <Input id='direccion' type='text' name='direccion' value={data.direccion} readOnly />
            </div>
            <div className='flex-1'>
              <Label htmlFor='distrito'>Distrito</Label>
              <Input id='distrito' type='text' name='distrito' value={data.distrito} readOnly />
            </div>
          </div>
        </div>
      </div>
    </AppLayout>
  )
}
