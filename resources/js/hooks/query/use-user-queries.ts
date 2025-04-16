import { userQueryKeys, userService } from '@/services/user-service'
import { useQuery } from '@tanstack/react-query'

export function useUser(userId: number, isEdit: boolean, options = {}) {
  return useQuery({
    queryKey: userQueryKeys.detail(userId, isEdit),
    queryFn: () => userService.fetchUser(userId, isEdit),
    enabled: !!userId,
    ...options
  })
}
