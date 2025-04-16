export interface Image {
  id: number
  url: string
  imageable_id: number // ID del modelo relacionado (Actividad, Logro, etc.)
  imageable_type: string // Nombre del modelo relacionado (e.g., 'App\\Models\\Actividad')
  created_at: string
  updated_at: string
}
