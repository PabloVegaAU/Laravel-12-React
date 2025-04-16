export interface Logro {
  id: number
  nombre: string
  descripcion: string
  tipo: 'BASICO' | 'REGULAR' | 'NORMAL' | 'BUENO' | 'MUY BUENO' | 'EXCELENTE'
  exp_req: number | null
  es_comprable: boolean
  created_at: string
  updated_at: string
}
