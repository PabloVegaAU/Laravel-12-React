import { useUser } from '@/hooks/query/use-user-queries'
import { userQueryKeys } from '@/services/user-service'
import { Role } from '@/types'
import { useForm } from '@inertiajs/react'
import { useQueryClient } from '@tanstack/react-query'
import { useCallback, useEffect } from 'react'

type UseUserFormProps = {
  userId: number
  update: boolean
  onSuccess: () => void
}

type UserFormData = {
  email: string
  name: string
  apellido: string
  fecha_nac: string
  dni: string
  edad: string
  sexo: string
  direccion: string
  distrito: string
  rol: number[]
  [key: string]: any
}

export function useUserForm({ userId, update, onSuccess }: UseUserFormProps) {
  const queryClient = useQueryClient()
  const { data: user, isLoading, error } = useUser(userId, update)

  const { data, setData, put, processing, errors, setError } = useForm<UserFormData>({
    email: '',
    name: '',
    apellido: '',
    fecha_nac: '',
    dni: '',
    edad: '',
    sexo: '',
    direccion: '',
    distrito: '',
    rol: []
  })

  useEffect(() => {
    if (error) {
      setError('general', error.message)
    }
  }, [error, setError])

  useEffect(() => {
    if (user) {
      setData({
        email: user.email ?? '',
        name: user.perfil?.nombre ?? '',
        apellido: user.perfil?.apellido ?? '',
        fecha_nac: user.perfil?.fecha_nac ?? '',
        dni: user.perfil?.dni ?? '',
        edad: user.perfil?.edad?.toString() ?? '',
        sexo: user.perfil?.sexo ?? '',
        direccion: user.perfil?.direccion ?? '',
        distrito: user.perfil?.distrito ?? '',
        rol: user.roles?.map((role: Role) => role.id) ?? []
      })
    }
  }, [user, setData])

  const submit = useCallback(
    (e: React.FormEvent) => {
      e?.preventDefault()
      const url = update ? route('admin.users.update', userId) : route('admin.users.store')

      put(url, {
        onSuccess: () => {
          // Eliminar la caché manualmente
          queryClient.removeQueries({
            queryKey: userQueryKeys.detail(userId)
          })
          onSuccess?.()
        }
      })
    },
    [update, userId, put, onSuccess]
  )

  return {
    models: {
      data,
      errors,
      isLoading: isLoading || processing,
      canEdit: update && !isLoading
    },
    operations: {
      setData,
      submit
    }
  }
}
