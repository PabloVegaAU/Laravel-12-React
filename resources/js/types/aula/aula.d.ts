import { Actividad, Carpeta, Materia } from '../actividades'
import { Alumno, Docente } from '../user'
import { Grado } from './grado'
import { Seccion } from './seccion'

export type Aula = {
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

export type AulaDocenteMateria = {
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
