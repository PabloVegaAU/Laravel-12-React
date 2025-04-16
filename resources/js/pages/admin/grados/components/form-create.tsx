import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import InputError from '@/components/ui/input-error'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import { Niveles } from '@/constants'
import { useForm } from '@inertiajs/react'
import { LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

interface FormCreateProps {
  onFormSuccess: () => void
}

export default function FormCreate({ onFormSuccess }: FormCreateProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    nombre: '',
    nivel: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.grados.store'), {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        reset()
        onFormSuccess()
      }
    })
  }

  return (
    <>
      {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

      <form onSubmit={submit}>
        <div className='space-y-6'>
          <div>
            <Label htmlFor='nombre'>Nombre</Label>
            <Input type='text' value={data.nombre} onChange={(e) => setData('nombre', e.target.value)} />
            <InputError message={errors.nombre} />
          </div>

          <div>
            <Label htmlFor='nivel'>Seleccione un nivel</Label>
            <Select value={data.nivel} onValueChange={(value) => setData('nivel', value)}>
              <SelectTrigger id='nivel' name='nivel'>
                <SelectValue placeholder='Seleccione un nivel' />
              </SelectTrigger>
              <SelectContent>
                {Niveles.map((i) => (
                  <SelectItem key={i} value={i}>
                    {i}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            <InputError message={errors.nivel} />
          </div>

          {/* Botón de Envío */}
          <div className='flex items-center'>
            <Button className='w-full' disabled={processing}>
              {processing && <LoaderCircle className='h-4 w-4 animate-spin' />}
              Agregar
            </Button>
          </div>
        </div>
      </form>
    </>
  )
}
