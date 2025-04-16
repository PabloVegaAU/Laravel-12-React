import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import InputError from '@/components/ui/input-error'
import { Label } from '@/components/ui/label'
import { useForm } from '@inertiajs/react'
import { LoaderCircle } from 'lucide-react'
import { FormEventHandler } from 'react'

interface FormCreateProps {
  onFormSuccess: () => void
}

export default function FormCreate({ onFormSuccess }: FormCreateProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    nombre: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    post(route('admin.secciones.store'), {
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

      <form onSubmit={submit} className='space-y-6'>
        <div>
          <Label htmlFor='nombre'>Sección</Label>
          <Input
            type='text'
            name='nombre'
            id='nombre'
            placeholder='Nombre de la sección'
            value={data.nombre}
            onChange={(e) => setData('nombre', e.target.value)}
          />
          <InputError message={errors.nombre} />
        </div>

        {/* Botón de Envío */}
        <div className='flex items-center'>
          <Button className='w-full' disabled={processing}>
            {processing && <LoaderCircle className='h-4 w-4 animate-spin' />}
            Agregar
          </Button>
        </div>
      </form>
    </>
  )
}
