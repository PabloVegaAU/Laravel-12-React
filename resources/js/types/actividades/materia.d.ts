export interface Materia {
  id: number
  nombre: string
  created_at: string
  updated_at: string
  aulas_docentes_materias?: AulaDocenteMateria[]
}
