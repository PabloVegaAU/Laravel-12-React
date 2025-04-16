import type { Config } from 'ziggy-js'

export type SharedData = {
  name: string
  quote: { message: string; author: string }
  auth: Auth
  ziggy: Config & { location: string }
  sidebarOpen: boolean
  [key: string]: unknown
}
