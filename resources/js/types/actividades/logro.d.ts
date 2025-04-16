export type LogroType = 'BASICO' | 'REGULAR' | 'NORMAL' | 'BUENO' | 'MUY BUENO' | 'EXCELENTE'

export type Logro = {
  id: number
  nombre: string
  descripcion: string
  tipo: LogroType
  exp_req: number | null
  es_comprable: boolean
  created_at: string
  updated_at: string
}
