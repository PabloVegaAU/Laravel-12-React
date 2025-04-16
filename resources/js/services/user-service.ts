import { User } from '@/types'

// Claves de consulta
// En user-service.ts
export const userQueryKeys = {
  all: ['users'] as const,
  detail: (id: number, isEdit?: boolean) =>
    isEdit !== undefined ? [...userQueryKeys.all, 'detail', id, isEdit] : [...userQueryKeys.all, 'detail', id]
}

// Servicio
export const userService = {
  fetchUser: async (userId: number, isEdit: boolean): Promise<User> => {
    const endpoint = isEdit ? route('admin.users.edit', userId) : route('admin.users.show', userId)

    const response = await fetch(endpoint)

    if (!response.ok) {
      const error = await response.json().catch(() => ({}))
      throw new Error(error.message || 'Error al cargar el usuario')
    }

    const res = await response.json()
    return res.user
  }
}
