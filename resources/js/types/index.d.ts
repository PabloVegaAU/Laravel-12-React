import type { LucideIcon } from 'lucide-react'
import type { Config } from 'ziggy-js'

export interface Auth {
  user: User
}

export interface BreadcrumbItem {
  title: string
  href: string
}

export interface NavGroup {
  title: string
  items: NavItem[]
}

export interface NavItem {
  title: string
  href: string
  icon?: LucideIcon | null
  isActive?: boolean
}

export interface SharedData {
  name: string
  quote: { message: string; author: string }
  auth: Auth
  ziggy: Config & { location: string }
  sidebarOpen: boolean
  [key: string]: unknown
}

export interface User {
  id: number
  name: string
  email: string
  avatar?: string
  email_verified_at: string | null
  created_at: string
  updated_at: string
  perfil?: Perfil
  [key: string]: unknown
}

export interface Perfil {
  id: number
  nombre: string
  apellido: string
  fecha_nac: string
  DNI: string
  edad: string
  sexo: string
  direccion: string
  distrito: string
  user_id: number
  created_at: string
  updated_at: string
}

export interface Docente {
  user_id: number
  user?: User
  materias: Materia[]
  secciones: Seccion[]
  created_at: string
  updated_at: string
}

export interface Alumno {
  user_id: number
  user: User
  seccion_id: number
  seccion: Seccion
  created_at: string
  updated_at: string
}

export interface Materia {
  id: number
  nombre: string
  descripcion
}

export interface Seccion {
  id: number
  nombre: string
  grado: Grado
}

export interface Grado {
  id: number
  grado: string
  nivel: string
}

export type ResourcePageProps<T> = {
  data: PaginatedResponse<T>
  filters: {
    search?: string
    sort?: string
    direction?: 'asc' | 'desc'
  }
  flash?: FlashMessage
}

export interface PaginatedResponse<T> {
  current_page: number
  data: T[]
  first_page_url: string
  from: number | null
  last_page: number
  last_page_url: string
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
  next_page_url: string | null
  path: string
  per_page: number
  prev_page_url: string | null
  to: number | null
  total: number
}

export type FlashMessage = {
  level: 'info' | 'notice' | 'warning' | 'alert' | 'critical'
  message: string
}

export type Column<T> =
  {
    accessorKey: string;
    header: string;
    renderCell?: (v: T) => string | React.ReactNode;
  }
