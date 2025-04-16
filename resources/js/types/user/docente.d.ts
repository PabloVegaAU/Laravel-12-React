import type { Materia } from '../academic'
import type { Aula, AulaDocenteMateria } from '../aula/aula.js'
import type { User } from '../user.js'
import { Perfil } from './perfil'

export type Docente = {
  user_id: number
  created_at: string
  updated_at: string
  user?: User
  perfil?: Perfil
  materias?: Materia[]
  aulas_docentes_materias?: AulaDocenteMateria[]
  aulas?: Aula[]
}
