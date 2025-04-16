import type { User } from './user.d.ts'

export interface Perfil {
  user_id: number
  nombre: string
  apellido: string
  fecha_nac: string
  dni: string
  edad: number
  sexo: 'm' | 'f'
  direccion: string
  distrito: string
  user?: User
  created_at: string
  updated_at: string
}
