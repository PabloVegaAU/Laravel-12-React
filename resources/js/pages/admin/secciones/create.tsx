import InputError from '@/components/input-error'
import { Button } from '@/components/ui/button'
import { Label } from '@/components/ui/label'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { BreadcrumbItem } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import { FormEventHandler } from 'react'

interface PageProps {
  listasec: string[]
  selectgr: Record<number, string>
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Crear Sección',
    href: '/admin/secciones/create'
  }
]

export default function CreateSeccionPage({ listasec, selectgr }: PageProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    nombre: '',
    grado_id: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    post(route('admin.secciones.store'), {
      onSuccess: () => reset()
    })
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Crear Sección' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/secciones' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Crear Sección</h1>
        </div>

        {errors.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit} className='space-y-6'>
          {/* Selección de Sección */}
          <div>
            <Label htmlFor='nombre'>Sección</Label>
            <Select value={data.nombre} onValueChange={(value) => setData('nombre', value)}>
              <SelectTrigger id='nombre' name='nombre'>
                <SelectValue placeholder='Elija una sección...' />
              </SelectTrigger>
              <SelectContent>
                {listasec.map((sec) => (
                  <SelectItem key={sec} value={sec}>
                    {sec}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            <InputError message={errors.nombre} />
          </div>

          {/* Selección de Grado */}
          <div>
            <Label htmlFor='grado_id'>Grado</Label>
            <Select value={data.grado_id} onValueChange={(value) => setData('grado_id', value)}>
              <SelectTrigger id='grado_id' name='grado_id'>
                <SelectValue placeholder='Elija un grado...' />
              </SelectTrigger>
              <SelectContent>
                {Object.entries(selectgr).map(([id, label]) => (
                  <SelectItem key={id} value={id}>
                    {label}
                  </SelectItem>
                ))}
              </SelectContent>
            </Select>
            <InputError message={errors.grado_id} />
          </div>

          {/* Botón de Envío */}
          <div className='flex items-center'>
            <Button className='w-full' disabled={processing}>
              {processing && <LoaderCircle className='h-4 w-4 animate-spin' />}
              Crear
            </Button>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
