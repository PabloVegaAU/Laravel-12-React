import type { Grado, Seccion } from '../../academic'
import type { Actividad, Carpeta } from '../../actividades'
import type { Alumno } from './alumno.d.ts'
import type { AulaDocenteMateria } from './aula-docente-materia.d.ts'

export interface Aula {
  id: number
  seccion_id: number | null
  grado_id: number | null
  anio: number
  alumnos?: Alumno[]
  docentesMaterias?: AulaDocenteMateria[]
  seccion?: Seccion
  grado?: Grado
  carpetas?: Carpeta[]
  actividades?: Actividad[]
  created_at: string
  updated_at: string
}

export interface AulaDocenteMateria {
  id: number
  aula_id: number
  docente_id: number
  materia_id: number
  created_at: string
  updated_at: string
  aula?: Aula
  docente?: Docente
  materia?: Materia
}
