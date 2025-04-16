import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { User } from '@/types'
import { useForm } from '@inertiajs/react'
import { LoaderCircle } from 'lucide-react'
import { useEffect, useState, type FormEventHandler } from 'react'

interface FormEditProps {
  userId: number
  onFormSuccess: () => void
}

export default function FormEdit({ userId, onFormSuccess }: FormEditProps) {
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    setIsLoading(true)
    fetch(route('admin.users.edit', userId))
      .then((response) => response.json())
      .then((user: User) => {
        setData({
          email: user.email ?? '',
          password: '',
          name: user.perfil?.nombre ?? '',
          apellido: user.perfil?.apellido ?? '',
          fecha: user.perfil?.fecha_nac ?? '',
          dni: user.perfil?.dni ?? '',
          edad: `${user.perfil?.edad ?? ''}`,
          sexo: user.perfil?.sexo ?? '',
          direccion: user.perfil?.direccion ?? '',
          distrito: user.perfil?.distrito ?? ''
        })
      })
      .catch((e) => {
        setError('general', 'Error al cargar los datos del usuario.' + e)
      })
      .finally(() => {
        setIsLoading(false)
      })
  }, [userId])

  const { data, setData, put, processing, errors, setError, reset } = useForm<Required<any>>({
    email: '',
    password: '',
    name: '',
    apellido: '',
    fecha: '',
    dni: '',
    edad: '',
    sexo: '',
    direccion: '',
    distrito: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    put(route('admin.users.update', userId), {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        reset()
        onFormSuccess()
      }
    })
  }

  const lock = processing || isLoading

  return (
    <>
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
                onChange={(e) => setData('email', e.target.value)}
                readOnly={lock}
              />
              <InputError message={errors.email} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='password'>Contraseña (opcional)</Label>
              <Input
                id='password'
                type='password'
                name='password'
                autoComplete='new-password'
                value={data.password}
                onChange={(e) => setData('password', e.target.value)}
                readOnly={lock}
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
                onChange={(e) => setData('name', e.target.value)}
                readOnly={lock}
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
                onChange={(e) => setData('apellido', e.target.value)}
                readOnly={lock}
              />
              <InputError message={errors.apellido} />
            </div>
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='fecha'>Fecha</Label>
              <Input id='fecha' type='date' name='fecha' value={data.fecha} onChange={(e) => setData('fecha', e.target.value)} readOnly={lock} />
              <InputError message={errors.fecha} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='dni'>DNI</Label>
              <Input id='dni' type='number' name='dni' value={data.dni} onChange={(e) => setData('dni', e.target.value)} readOnly={lock} />
              <InputError message={errors.dni} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='edad'>Edad</Label>
              <Input id='edad' type='text' name='edad' value={data.edad} onChange={(e) => setData('edad', e.target.value)} readOnly={lock} />
              <InputError message={errors.edad} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='sexo'>Sexo</Label>
              <Select value={data.sexo} onValueChange={(e) => setData('sexo', e)} disabled={lock}>
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
                onChange={(e) => setData('direccion', e.target.value)}
                disabled={lock}
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
                onChange={(e) => setData('distrito', e.target.value)}
                disabled={lock}
              />
              <InputError message={errors.distrito} />
            </div>
          </div>

          <div className='flex items-center'>
            <Button className='w-full' disabled={lock}>
              {lock && <LoaderCircle className='h-4 w-4 animate-spin' />}
              Guardar Cambios
            </Button>
          </div>
        </div>
      </form>
    </>
  )
}
