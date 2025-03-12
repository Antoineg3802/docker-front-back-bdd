import { ref, computed } from 'vue'
import { jwtDecode } from 'jwt-decode'

interface JwtPayload {
  exp: number
}

const token = ref<string | null>(localStorage.getItem('jwtToken'))

export function setToken(newToken: string) {
  token.value = newToken
  localStorage.setItem('jwtToken', newToken)
}

export function removeToken() {
  token.value = null
  localStorage.removeItem('jwtToken')
}

export const isAuthenticated = computed((): boolean => {
  if (!token.value) return false
  try {
    const decoded = jwtDecode<JwtPayload>(token.value)
    // Vérifier que le token n'est pas expiré (exp est en secondes)
    return decoded.exp * 1000 > Date.now()
  } catch (error) {
    return false
  }
})

export function useAuth() {
  return { token, setToken, removeToken, isAuthenticated }
}
