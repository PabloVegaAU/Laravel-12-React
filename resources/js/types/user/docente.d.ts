import type { Materia, Seccion } from '../academic'
import type { Aula, AulaDocenteMateria } from '../aula/aula.js'
import type { User } from '../user.js'

export interface Docente {
  user_id: number
  created_at: string
  updated_at: string
  user?: User
  materias?: Materia[]
  secciones?: Seccion[]
  aulas_docentes_materias?: AulaDocenteMateria[]
  aulas?: Aula[]
}
