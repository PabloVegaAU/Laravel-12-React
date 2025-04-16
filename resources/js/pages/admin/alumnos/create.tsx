import { Button } from '@/components/ui/button'
import InputError from '@/components/ui/input-error'
import { Label } from '@/components/ui/label'
import { SearchableSelect, Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import AppLayout from '@/layouts/app-layout'
import type { Aula, BreadcrumbItem, User } from '@/types'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'
import React from 'react'

interface PageProps {
  users: User[]
  aulas: Aula[]
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Agregar Alumno',
    href: '/admin/alumnos/create'
  }
]

export default function Page({ users, aulas }: PageProps) {
  const { data, setData, post, processing, errors, reset } = useForm<Required<any>>({
    user_id: '',
    aula_id: ''
  })

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.alumnos.store'), {
      onSuccess: () => reset()
    })
  }

  const [searchTerm, setSearchTerm] = React.useState('')

  const filteredAulas = React.useMemo(() => {
    if (!searchTerm.trim()) return aulas

    return aulas.filter((aula) => {
      const searchLower = searchTerm.toLowerCase()
      return (
        aula?.grado?.nivel?.toLowerCase().includes(searchLower) ||
        aula?.grado?.nombre?.toLowerCase().includes(searchLower) ||
        aula?.seccion?.nombre?.toLowerCase().includes(searchLower) ||
        `${aula?.grado?.nivel || ''} ${aula?.grado?.nombre || ''} ${aula?.seccion?.nombre || ''}`.toLowerCase().includes(searchLower)
      )
    })
  }, [aulas, searchTerm])

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Agregar Alumno' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/alumnos' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Agregar Alumno</h1>
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
                      {`${user?.perfil?.nombre} ${user?.perfil?.apellido}, DNI: ${user?.perfil?.dni}`}
                    </SelectItem>
                  ))}
                </SelectContent>
              </Select>
              <InputError message={errors.user_id} />
            </div>

            {/* Selección de Aula */}
            <div>
              <Label htmlFor='aula_id'>Seleccione un aula</Label>
<SearchableSelect
  value={data.aula_id}
  onValueChange={(value) => {
    setData('aula_id', value)
    setSearchTerm('') // Limpiar búsqueda al seleccionar
  }}
  searchValue={searchTerm}
  onSearchChange={setSearchTerm}
  placeholder={
    aulas.find((a) => a.id.toString() === data.aula_id)
      ? `${aulas.find((a) => a.id.toString() === data.aula_id)?.grado?.nivel} ${aulas.find((a) => a.id.toString() === data.aula_id)?.grado?.nombre} ${aulas.find((a) => a.id.toString() === data.aula_id)?.seccion?.nombre}`
      : 'Seleccione un aula'
  }
  searchPlaceholder='Buscar por grado, sección o nivel...'
>
  {filteredAulas.map((aula) => (
    <SelectItem key={aula.id} value={aula.id.toString()}>
      {aula?.grado?.nivel} {`${aula?.grado?.nombre} ${aula?.seccion?.nombre}`}
    </SelectItem>
  ))}
  {filteredAulas.length === 0 && <div className='text-muted-foreground px-2 py-1.5 text-sm'>No se encontraron resultados</div>}
</SearchableSelect>
              <InputError message={errors.aula_id} />
            </div>

            {/* Botón de Envío */}
            <div className='flex items-center'>
              <Button variant='outline-info' className='w-full' disabled={processing}>
                {processing && <LoaderCircle className='h-4 w-4 animate-spin' />}
                Agregar
              </Button>
            </div>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
