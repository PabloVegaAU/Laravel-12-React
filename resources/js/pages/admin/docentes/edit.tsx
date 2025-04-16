import { Button } from '@/components/ui/button'
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card'
import { Collapse, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible'
import { Label } from '@/components/ui/label'
import { MultiSelect } from '@/components/ui/multi-select'
import AppLayout from '@/layouts/app-layout'
import type { Docente } from '@/types'
import type { BreadcrumbItem } from '@/types/core/navigation'
import type { PageProps } from '@inertiajs/core'
import { Head, Link, useForm } from '@inertiajs/react'
import { ArrowLeft, LoaderCircle, Trash2Icon } from 'lucide-react'
import type { FormEventHandler } from 'react'
import { useMemo, useState } from 'react'

type AulaMaterias = {
  aula_id: number
  materia_ids: number[]
}

type MateriaAsignada = {
  aula_id: number
  materia_id: number
  materia_nombre: string
}

type Materia = {
  id: number
  nombre: string
}

type Seccion = {
  id: number
  nombre: string
  aula_id: number
  materias: Materia[]
}

type Grado = {
  id: number
  nombre: string
  secciones: Seccion[]
}

type Nivel = {
  [key: string]: Grado[]
}

type EditDocentePageProps = PageProps & {
  docente: Docente
  niveles: Nivel
  materias: Materia[]
  materiasAsignadas: MateriaAsignada[]
  currentYear: number
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Docentes',
    href: '/admin/docentes'
  },
  {
    title: 'Editar docente',
    href: '/admin/docentes/edit'
  }
]

export default function EditDocentePage({ docente, niveles, materias, materiasAsignadas, currentYear }: EditDocentePageProps) {
  // Convertir materiasAsignadas a un formato más manejable
  const materiasPorAula = useMemo(() => {
    const materiasPorAula: Record<number, any[]> = {}
    materiasAsignadas.forEach((ma) => {
      if (!materiasPorAula[ma.aula_id]) {
        materiasPorAula[ma.aula_id] = []
      }
      materiasPorAula[ma.aula_id].push(ma)
    })
    return materiasPorAula
  }, [materiasAsignadas])

  // Inicializar las aulas y materias asignadas
  const initialAulasMaterias: AulaMaterias[] =
    (docente.aulas_docentes_materias || []).reduce<AulaMaterias[]>((acc, adm) => {
      const existingAula = acc.find((a) => a.aula_id === adm.aula_id)
      if (existingAula) {
        existingAula.materia_ids.push(adm.materia_id)
      } else {
        acc.push({
          aula_id: adm.aula_id,
          materia_ids: [adm.materia_id]
        })
      }
      return acc
    }, []) || []

  const [aulasMaterias, setAulasMaterias] = useState<AulaMaterias[]>(initialAulasMaterias)

  const { data, setData, put, processing, errors, reset } = useForm({
    aulas_materias: initialAulasMaterias, // Ya no usamos JSON.stringify
    general: ''
  })

  const removeAulaMateria = (index: number) => {
    const updated = aulasMaterias.filter((_, i) => i !== index)
    setAulasMaterias(updated)
    setData('aulas_materias', updated) // Ya no usamos JSON.stringify
  }

  const updateAulaMaterias = (aulaId: number, materiaIds: number[]) => {
    setAulasMaterias((prev) => {
      // Agregar un nuevo array sin el aula que estamos actualizando
      const updated = prev.filter((am) => am.aula_id !== aulaId)

      // Solo agregar el aula si hay materias seleccionadas
      if (materiaIds.length > 0) {
        updated.push({
          aula_id: aulaId,
          materia_ids: [...materiaIds]
        })
      }

      // Actualizar los datos del formulario directamente con el array
      setData('aulas_materias', updated)

      return updated
    })
  }

  const submit: FormEventHandler = (e) => {
    e.preventDefault()
    console.log('Enviando datos:', data) // Agrega esta línea
    put(route('admin.docentes.update', docente.user_id))
  }

  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Editar Docente' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/docentes' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Editar Docente</h1>
        </div>

        {errors?.general && <div className='mb-4 rounded bg-red-100 p-3 text-red-800'>{errors.general}</div>}

        <form onSubmit={submit} className='space-y-6'>
          {/* Información del Docente */}
          <Card>
            <CardHeader>
              <CardTitle className='text-lg'>Información del Docente</CardTitle>
            </CardHeader>
            <CardContent className='space-y-4'>
              <div className='grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3'>
                <div>
                  <Label className='text-sm font-medium text-gray-500'>Nombre Completo</Label>
                  <div className='mt-1'>
                    {docente.user?.perfil?.nombre} {docente.user?.perfil?.apellido}
                  </div>
                </div>
                <div>
                  <Label className='text-sm font-medium text-gray-500'>DNI</Label>
                  <div className='mt-1'>{docente.user?.perfil?.dni || 'No especificado'}</div>
                </div>
                <div>
                  <Label className='text-sm font-medium text-gray-500'>Email</Label>
                  <div className='mt-1'>{docente.user?.email || 'No especificado'}</div>
                </div>
              </div>
            </CardContent>
          </Card>

          {/* Aulas y Materias Asignadas */}
          <Card>
            <CardHeader>
              <CardTitle className='text-lg'>Asignación de Aulas y Materias</CardTitle>
              <p className='text-sm text-gray-500'>Año lectivo: {currentYear}</p>
            </CardHeader>
            <CardContent>
              {Object.entries(niveles).map(([nivel, grados]) => (
                <Collapse key={nivel} className='space-y-3'>
                  <CollapsibleTrigger className='flex w-full items-center justify-between'>
                    <h3 className='text-lg font-semibold'>{nivel}</h3>
                  </CollapsibleTrigger>
                  <CollapsibleContent className='space-y-3'>
                    {grados.map((grado) => (
                      <Collapse key={grado.id} className='rounded-lg border p-2'>
                        <CollapsibleTrigger className='flex w-full items-center justify-between'>
                          <h4 className='text-md font-medium'>{grado.nombre}</h4>
                          <span className='rounded-full bg-blue-100 px-2 text-xs text-blue-800'>
                            {grado.secciones.length} {grado.secciones.length === 1 ? 'sección' : 'secciones'}
                          </span>
                        </CollapsibleTrigger>

                        <CollapsibleContent className='space-y-3 pt-3'>
                          {grado.secciones.map((seccion) => {
                            const materiasAsignadas = materiasPorAula[seccion.aula_id] || []
                            const aulaMateriaIndex = aulasMaterias.findIndex((am) => am.aula_id === seccion.aula_id)

                            return (
                              <div key={seccion.aula_id} className='space-y-2 rounded-lg border p-4'>
                                <div className='flex items-center justify-between'>
                                  <h5 className='font-medium'>Sección {seccion.nombre}</h5>
                                  <Button
                                    type='button'
                                    variant='ghost'
                                    size='sm'
                                    className='text-red-600 hover:bg-red-50 hover:text-red-700'
                                    onClick={() => removeAulaMateria(aulaMateriaIndex)}
                                  >
                                    <Trash2Icon className='h-4 w-4' />
                                  </Button>
                                </div>

                                {aulaMateriaIndex >= 0 && (
                                  <div className='mt-2'>
                                    <Label htmlFor={`materias-${seccion.aula_id}`} className='text-sm font-medium text-gray-700'>
                                      Materias asignadas
                                    </Label>
                                    <MultiSelect
                                      id={`materias-${seccion.aula_id}`}
                                      options={
                                        materias?.map((materia) => ({
                                          value: materia.id.toString(),
                                          label: materia.nombre
                                        })) || []
                                      }
                                      value={
                                        data.aulas_materias
                                          ? data.aulas_materias.find((am: any) => am.aula_id === seccion.aula_id)?.materia_ids?.map(String) || []
                                          : []
                                      }
                                      onChange={(vals) => {
                                        console.log('vals', vals)
                                        updateAulaMaterias(seccion.aula_id, vals.map(Number))
                                      }}
                                      placeholder='Seleccione materias...'
                                      className='mt-1'
                                    />
                                    <p className='mt-1 text-xs text-gray-500'>Seleccione las materias que imparte en esta sección</p>
                                  </div>
                                )}

                                {/* Mostrar materias ya asignadas */}
                                {seccion.materias?.length > 0 && (
                                  <div className='mt-3'>
                                    <h6 className='mb-2 text-sm font-medium text-gray-700'>Materias actuales:</h6>
                                    <div className='flex flex-wrap gap-2'>
                                      {seccion.materias.map((materia) => (
                                        <span
                                          key={materia.id}
                                          className='inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800'
                                        >
                                          {materia.nombre}
                                        </span>
                                      ))}
                                    </div>
                                  </div>
                                )}
                              </div>
                            )
                          })}
                        </CollapsibleContent>
                      </Collapse>
                    ))}
                  </CollapsibleContent>
                </Collapse>
              ))}
            </CardContent>
          </Card>

          {/* Botón de Envío */}
          <div className='flex justify-end space-x-4 pt-4'>
            <Button type='button' variant='outline' asChild>
              <Link href={route('admin.docentes.index')}>Cancelar</Link>
            </Button>
            <Button type='submit' disabled={processing}>
              {processing && <LoaderCircle className='mr-2 h-4 w-4 animate-spin' />}
              Guardar Cambios
            </Button>
          </div>
        </form>
      </div>
    </AppLayout>
  )
}
