import type { Alumno } from './alumno.d.ts'
import type { Docente } from './docente.d.ts'
import type { Mensaje } from './mensaje.d.ts'
import type { Perfil } from './perfil.d.ts'

export interface User {
  id: number
  name: string
  email: string
  avatar?: string
  email_verified_at: string | null
  created_at: string
  updated_at: string
  perfil?: Perfil
  docente?: Docente
  alumno?: Alumno
  roles?: string[]
  permissions?: string[]
  messages?: Mensaje[]
  [key: string]: unknown
}
