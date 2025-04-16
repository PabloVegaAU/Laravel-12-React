import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Collapse, CollapsibleContent, CollapsibleTrigger } from '@/components/ui/collapsible'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { useInitials } from '@/hooks/use-initials'
import AppLayout from '@/layouts/app-layout'
import type { Aula, AulaDocenteMateria, BreadcrumbItem, Docente, Materia } from '@/types'
import { Head, Link } from '@inertiajs/react'

import { ArrowLeft } from 'lucide-react'

interface PageProps {
  docente: Docente
}

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Ver docente',
    href: '/admin/docentes/show'
  }
]

type GroupedAulas = {
  [year: number]: {
    [nivel: string]: {
      [grade: string]: {
        [section: string]: Array<{
          aula: Aula
          materia: Materia | null
        }>
      }
    }
  }
}

function groupAulasByYearGradeSection(aulasDocentesMaterias: AulaDocenteMateria[] = []): GroupedAulas {
  return aulasDocentesMaterias.reduce<GroupedAulas>((acc, adm) => {
    const aula = adm.aula
    if (!aula?.grado?.nivel) return acc

    const year = aula.anio
    const nivel = aula.grado.nivel || 'Sin nivel'
    const grade = aula.grado?.nombre || 'Sin grado'
    const section = aula.seccion?.nombre || 'Sin sección'

    if (!acc[year]) acc[year] = {}
    if (!acc[year][nivel]) acc[year][nivel] = {}
    if (!acc[year][nivel][grade]) acc[year][nivel][grade] = {}
    if (!acc[year][nivel][grade][section]) {
      acc[year][nivel][grade][section] = []
    }

    acc[year][nivel][grade][section].push({
      aula,
      materia: adm.materia ?? null
    })

    return acc
  }, {})
}
export default function Page({ docente }: PageProps) {
  const aulasGrouped = groupAulasByYearGradeSection(docente.aulas_docentes_materias)
  const getInitials = useInitials()
  return (
    <AppLayout breadcrumbs={breadcrumbs}>
      <Head title='Ver Docente' />
      <div className='flex h-full flex-1 flex-col gap-4 rounded-xl p-4'>
        <div className='flex items-center gap-3'>
          <Link href='/admin/docentes' className='rounded bg-blue-700 px-4 py-2 font-bold text-white hover:bg-blue-500'>
            <ArrowLeft />
          </Link>
          <h1 className='text-2xl font-bold'>Ver Docente</h1>
        </div>

        <div className='space-y-2'>
          {/* Información del docente */}
          <Collapse opened>
            <CollapsibleTrigger className='bg-transparent'>
              <h2 className='text-lg font-semibold'>Información personal</h2>
            </CollapsibleTrigger>
            <CollapsibleContent className='mt-2'>
              <div className='flex gap-6'>
                {/* Avatar */}
                <div className='bg-muted flex-1/6 rounded-lg'>
                  <Avatar className='size-full items-center overflow-hidden rounded-none'>
                    <AvatarImage src={docente.user.avatar} alt={docente.user.name} className='object-contain' />
                    <AvatarFallback className='bg-muted h-1/2 w-full rounded-none'>{getInitials(docente.user.name)}</AvatarFallback>
                  </Avatar>
                </div>
                {/* Info */}
                <div className='flex flex-5/6 flex-col gap-3'>
                  <div className='flex-1'>
                    <Label htmlFor='email'>Correo Electrónico</Label>
                    <Input id='email' type='text' value={docente?.user?.email} readOnly />
                  </div>

                  <div className='flex gap-2'>
                    <div className='flex-1'>
                      <Label htmlFor='nombre'>Nombres</Label>
                      <Input id='nombre' type='text' value={docente?.perfil?.nombre} readOnly />
                    </div>

                    <div className='flex-1'>
                      <Label htmlFor='apellido'>Apellidos</Label>
                      <Input id='apellido' type='text' value={docente?.perfil?.apellido} readOnly />
                    </div>
                  </div>

                  <div className='flex gap-2'>
                    <div className='flex-1'>
                      <Label htmlFor='fecha'>Fecha</Label>
                      <Input id='fecha' type='text' value={docente?.perfil?.fecha_nac} readOnly />
                    </div>

                    <div className='flex-1'>
                      <Label htmlFor='edad'>Edad</Label>
                      <Input id='edad' type='text' value={docente?.perfil?.edad} readOnly />
                    </div>
                  </div>

                  <div className='flex gap-2'>
                    <div className='flex-1'>
                      <Label htmlFor='dni'>DNI</Label>
                      <Input id='dni' type='text' value={docente?.perfil?.dni} readOnly />
                    </div>

                    <div className='flex-1'>
                      <Label htmlFor='sexo'>Sexo</Label>
                      <Input id='sexo' type='text' value={docente?.perfil?.sexo} readOnly />
                    </div>
                  </div>

                  <div className='flex gap-2'>
                    <div className='flex-1'>
                      <Label htmlFor='dni'>Distrito</Label>
                      <Input id='distrito' type='text' value={docente?.perfil?.distrito} readOnly />
                    </div>

                    <div className='flex-1'>
                      <Label htmlFor='direccion'>Dirección</Label>
                      <Input id='direccion' type='text' value={docente?.perfil?.direccion} readOnly />
                    </div>
                  </div>
                </div>
              </div>
            </CollapsibleContent>
          </Collapse>

          {/* Aulas agrupadas */}
          <Collapse>
            <CollapsibleTrigger className='bg-transparent'>
              <h2 className='text-lg font-semibold'>Cursos</h2>
            </CollapsibleTrigger>
            <CollapsibleContent className='mt-2 ml-2'>
              {Object.entries(aulasGrouped).map(([year, niveles]) => (
                <Collapse key={year} className='mb-4'>
                  <CollapsibleTrigger className='w-full text-left'>
                    <h2 className='flex items-center gap-2 text-lg font-semibold'>Año: {year}</h2>
                  </CollapsibleTrigger>
                  <CollapsibleContent className='ml-4'>
                    {Object.entries(niveles).map(([nivel, grados]) => (
                      <Collapse key={`${year}-${nivel}`} className='mb-3'>
                        <CollapsibleTrigger className='w-full text-left'>
                          <h3 className='text-md flex items-center gap-2 font-medium'>Nivel: {nivel}</h3>
                        </CollapsibleTrigger>
                        <CollapsibleContent className='ml-4'>
                          {Object.entries(grados).map(([grado, secciones]) => (
                            <Collapse key={`${year}-${nivel}-${grado}`} className='mb-2'>
                              <CollapsibleTrigger className='w-full text-left'>
                                <h4 className='text-md font-medium'>Grado: {grado}</h4>
                              </CollapsibleTrigger>
                              <CollapsibleContent className='ml-4'>
                                {Object.entries(secciones).map(([seccion, aulas]) => (
                                  <div key={`${year}-${nivel}-${grado}-${seccion}`} className='mb-2'>
                                    <h5 className='text-sm font-medium text-gray-600'>Sección: {seccion}</h5>
                                    <div className='mt-2 ml-4 space-y-2'>
                                      {aulas.map(({ materia }, idx) => (
                                        <div key={idx} className='rounded border border-gray-200 bg-gray-50 p-2'>
                                          <p className='text-sm'>
                                            <span className='font-medium'>Materia: </span>
                                            {materia?.nombre || 'Sin materia'}
                                          </p>
                                          {materia?.descripcion && <p className='mt-1 text-xs text-gray-500'>{materia.descripcion}</p>}
                                        </div>
                                      ))}
                                    </div>
                                  </div>
                                ))}
                              </CollapsibleContent>
                            </Collapse>
                          ))}
                        </CollapsibleContent>
                      </Collapse>
                    ))}
                  </CollapsibleContent>
                </Collapse>
              ))}
            </CollapsibleContent>
          </Collapse>
        </div>
      </div>
    </AppLayout>
  )
}
