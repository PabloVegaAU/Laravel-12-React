import { Button } from '@/components/ui/button'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import InputError from '@/components/ui/input-error'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Sexos } from '@/constants'
import { LoaderCircle } from 'lucide-react'
import { useUserForm } from './hooks'

interface FormEditProps {
  update: boolean
  userId: number
  onFormSuccess: () => void
}

export default function FormEdit({ update, userId, onFormSuccess }: FormEditProps) {
  const {
    models: { data, errors, isLoading, canEdit },
    operations: { setData, submit }
  } = useUserForm({
    userId,
    update,
    onSuccess: onFormSuccess
  })

  return (
    <>
      {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

      <form onSubmit={submit}>
        <div className='space-y-6'>
          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='email'>Correo Electrónico</Label>
              <Input
                id='email'
                type='email'
                name='email'
                autoComplete='email'
                value={data.email}
                readOnly={!canEdit}
                onChange={(e) => setData('email', e.target.value)}
              />
              <InputError message={errors.email} />
            </div>

            {update && (
              <div className='flex-1'>
                <Label htmlFor='password'>Contraseña</Label>
                <Input
                  id='password'
                  type='password'
                  name='password'
                  autoComplete='new-password'
                  value={data.password}
                  readOnly={!canEdit}
                  onChange={(e) => setData('password', e.target.value)}
                />
                <InputError message={errors.password} />
              </div>
            )}
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='name'>Nombres</Label>
              <Input id='name' type='text' name='name' value={data.name} readOnly={!canEdit} onChange={(e) => setData('name', e.target.value)} />
              <InputError message={errors.name} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='apellido'>Apellidos</Label>
              <Input
                id='apellido'
                type='text'
                name='apellido'
                value={data.apellido}
                readOnly={!canEdit}
                onChange={(e) => setData('apellido', e.target.value)}
              />
              <InputError message={errors.apellido} />
            </div>
          </div>

          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='fecha_nac'>Fecha</Label>
              <Input
                id='fecha_nac'
                type='date'
                name='fecha_nac'
                value={data.fecha_nac}
                readOnly={!canEdit}
                onChange={(e) => setData('fecha_nac', e.target.value)}
              />
              <InputError message={errors.fecha_nac} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='edad'>Edad</Label>
              <Input id='edad' type='number' name='edad' value={data.edad} readOnly={!canEdit} onChange={(e) => setData('edad', e.target.value)} />
              <InputError message={errors.edad} />
            </div>
          </div>
          <div className='flex gap-4'>
            <div className='flex-1'>
              <Label htmlFor='dni'>DNI</Label>
              <Input id='dni' type='text' name='dni' value={data.dni} readOnly={!canEdit} onChange={(e) => setData('dni', e.target.value)} />
              <InputError message={errors.dni} />
            </div>

            <div className='flex-1'>
              <Label htmlFor='sexo'>Sexo</Label>
              <Select key={`select-${data.sexo}`} value={data.sexo} onValueChange={(value) => setData('sexo', value)} disabled={!canEdit}>
                <SelectTrigger id='sexo' name='sexo'>
                  <SelectValue />
                </SelectTrigger>
                <SelectContent>
                  {Object.entries(Sexos).map(([value, label]) => (
                    <SelectItem key={value} value={value}>
                      {label}
                    </SelectItem>
                  ))}
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
                readOnly={!canEdit}
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
                readOnly={!canEdit}
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
                disabled={true}
              />
            </div>
            <InputError message={errors.rol} />
          </div>

          {update && (
            <div className='flex items-center'>
              <Button className='w-full' disabled={isLoading}>
                {isLoading && <LoaderCircle className='h-4 w-4 animate-spin' />}
                {isLoading ? 'Editando...' : 'Editar'}
              </Button>
            </div>
          )}
        </div>
      </form>
    </>
  )
}
