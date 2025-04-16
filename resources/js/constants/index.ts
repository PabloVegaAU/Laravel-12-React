import { NavItem } from '@/types'
import { Book, GraduationCap, Home, Puzzle, Users } from 'lucide-react'

export const noTitleNavItems: NavItem[] = [
  {
    title: 'Inicio',
    href: '/admin',
    icon: Home
  }
]

export const peopleNavItems: NavItem[] = [
  {
    title: 'Usuarios',
    href: '/admin/users',
    icon: Users
  },
  {
    title: 'Docentes',
    href: '/admin/docentes',
    icon: Users
  },
  {
    title: 'Alumnos',
    href: '/admin/alumnos',
    icon: Users
  }
]

export const schoolNavItems: NavItem[] = [
  {
    title: 'Grados',
    href: '/admin/grados',
    icon: GraduationCap
  },
  {
    title: 'Secciones',
    href: '/admin/secciones',
    icon: Puzzle
  },
  {
    title: 'Materias',
    href: '/admin/materias',
    icon: Book
  }
]
