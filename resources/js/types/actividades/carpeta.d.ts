export type EstadoCarpeta = 'ABIERTO' | 'CERRADO'

export type Carpeta = {
  id: number
  titulo: string
  descripcion: string
  fecha_inicio: string
  fecha_final: string
  estado: EstadoCarpeta
  aulas_docentes_materias_id: number | null
  created_at: string
  updated_at: string
}
