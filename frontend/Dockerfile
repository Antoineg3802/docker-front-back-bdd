# syntax=docker.io/docker/dockerfile:1

FROM node:18-alpine AS base

ENV PNPM_HOME="/pnpm"
ENV PATH="$PNPM_HOME:$PATH"
RUN corepack enable

# Étape de dépendances (on copie uniquement le lockfile et package.json)
FROM base AS deps
RUN apk add --no-cache libc6-compat
WORKDIR /app
COPY package.json yarn.lock* package-lock.json* pnpm-lock.yaml* .npmrc* ./
RUN pnpm install --frozen-lockfile --shamefully-hoist

# Étape de build
FROM base AS builder
WORKDIR /app
# Re-copier package.json et lockfiles et installer pour reconstruire node_modules
COPY package.json yarn.lock* package-lock.json* pnpm-lock.yaml* .npmrc* ./
RUN pnpm i --frozen-lockfile --shamefully-hoist
# Copier l'intégralité du code source
COPY . .
# Utiliser pnpm run build (assurez-vous que "build" est bien défini dans package.json)
RUN pnpm run build

# Étape de production
FROM base AS runner
WORKDIR /app

ENV NODE_ENV=production
ENV HOSTNAME="0.0.0.0"
ENV PORT=3000

RUN addgroup --system --gid 1001 nodejs && \
    adduser --system --uid 1001 nextjs

# Copier les fichiers statiques et le dossier standalone généré par Next
COPY --from=builder /app/public ./public
COPY --from=builder --chown=nextjs:nodejs /app/.next/standalone ./
COPY --from=builder --chown=nextjs:nodejs /app/.next/static ./.next/static

USER nextjs

EXPOSE 3000

# Dans le mode standalone, Next génère un fichier server.js (vérifiez son emplacement exact)
CMD ["node", "server.js"]
