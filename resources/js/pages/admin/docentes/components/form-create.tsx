import { Button } from '@/components/ui/button'
import InputError from '@/components/ui/input-error'
import { Label } from '@/components/ui/label'
import { MultiSelect } from '@/components/ui/multi-select'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select'
import type { Aula, Materia, User } from '@/types'
import { useForm } from '@inertiajs/react'
import { LoaderCircle } from 'lucide-react'
import type { FormEventHandler } from 'react'
import { useEffect, useState } from 'react'

interface FormCreateProps {
  onFormSuccess: () => void
}

export default function FormCreate({ onFormSuccess }: FormCreateProps) {
  const [isLoading, setIsLoading] = useState(true)
  const [users, setUsers] = useState<User[]>([])
  const [materias, setMaterias] = useState<Materia[]>([])
  const [aulas, setAulas] = useState<Aula[]>([])

  const { data, setData, post, processing, errors, setError, reset } = useForm<Required<any>>({
    user_id: '',
    aulas: [] as number[],
    materias: [] as number[]
  })

  useEffect(() => {
    setIsLoading(true)
    fetch(route('admin.docentes.create'))
      .then((response) => response.json())
      .then(({ users, aulas, materias }) => {
        setUsers(users)
        setMaterias(materias)
        setAulas(aulas)
      })
      .catch((e) => {
        setError('general', e)
      })
      .finally(() => {
        setIsLoading(false)
      })
  }, [])

  const submit: FormEventHandler = (e) => {
    e.preventDefault()

    post(route('admin.docentes.store'), {
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
          {/* SELECCIÓN DE USUARIO */}
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

          {/* SELECCIÓN DE AULAS */}
          <div>
            <Label htmlFor='aulas'>Aulas</Label>
            <MultiSelect
              id='aulas'
              name='aulas'
              placeholder='Seleccione aulas'
              options={aulas.map((a) => ({
                label: a.grado?.nombre + ' ' + a.seccion?.nombre + ' - ' + a.grado?.nivel,
                value: a.id.toString()
              }))}
              value={data.aulas.map(String)}
              onChange={(vals) => setData('aulas', vals.map(Number))}
              className='mt-1'
            />
            <InputError message={errors.aulas} />
          </div>

          {/* SELECCIÓN DE MATERIAS */}
          <div>
            <Label htmlFor='materias'>Materias</Label>
            <MultiSelect
              id='materias'
              name='materias'
              placeholder='Seleccione materias'
              options={materias.map((m) => ({
                label: m.nombre,
                value: m.id.toString()
              }))}
              value={data.materias.map(String)}
              onChange={(vals) => setData('materias', vals.map(Number))}
              maxSelections={5}
              className='mt-1'
            />
            <InputError message={errors.materias} />
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
