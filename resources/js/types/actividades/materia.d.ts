export type Materia = {
  id: number
  nombre: string
  descripcion: string
  created_at: string
  updated_at: string
  aulas_docentes_materias?: AulaDocenteMateria[]
}
