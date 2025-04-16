import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'

interface PageProps {
  gr: string[]
  niv: string[]
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Crear grado',
    href: '/admin/grados/create'
  }
]

export default function Page({ gr, niv }: PageProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    grado: '',
    nivel: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.grados.store'), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Crear Grado' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/grados' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Crear Grado</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit}>
          <div className='space-y-6'>
            {/* Selección de Grado */}
            <div>
              <Label htmlFor='grado'>Seleccione un grado</Label>
              <Select value={data.grado} onValueChange={(value) => setData('grado', value)}>
                <SelectTrigger id='grado' name='grado'>
                  <SelectValue placeholder='Seleccione un grado' />
                </SelectTrigger>
                <SelectContent>
                  {gr.map((i) => (
                    <SelectItem key={i} value={i}>
                      {i}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <InputError message={errors.grado} />
            </div>

            {/* Selección de Nivel */}
            <div>
              <Label htmlFor='nivel'>Seleccione un nivel</Label>
              <Select value={data.nivel} onValueChange={(value) => setData('nivel', value)}>
                <SelectTrigger id='nivel' name='nivel'>
                  <SelectValue placeholder='Seleccione un nivel' />
                </SelectTrigger>
                <SelectContent>
                  {niv.map((i) => (
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
                Crear
              </Button>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
