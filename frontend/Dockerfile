# =============================================================================
# 📁 ARQUIVO: frontend/Dockerfile
# =============================================================================
#
# ▸ O QUE É ESTE ARQUIVO?
#   Receita Docker para o container do frontend (React + Vite).
#
# ▸ O QUE PRECISO FAZER AQUI?
#
#   1. IMAGEM BASE: usar node:20-alpine (Node.js 20, imagem leve)
#      FROM node:20-alpine
#
#   2. DEFINIR DIRETÓRIO DE TRABALHO:
#      WORKDIR /app
#
#   3. COPIAR package.json e package-lock.json PRIMEIRO:
#      COPY package*.json ./
#      (Copiar antes do resto permite que o Docker faça cache do npm install)
#
#   4. INSTALAR DEPENDÊNCIAS:
#      RUN npm install
#
#   5. COPIAR O RESTO DOS ARQUIVOS:
#      COPY . .
#
#   6. EXPOR A PORTA DO VITE:
#      EXPOSE 5173
#
#   7. COMANDO PARA INICIAR O DEV SERVER:
#      CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
#      O --host 0.0.0.0 é necessário para acessar de fora do container.
#
# ▸ CONCEITOS QUE PRECISO ESTUDAR:
#   - Docker multi-stage builds (para produção no futuro)
#   - Node.js Alpine images (por que são menores)
#   - Cache de layers no Docker (por que copiar package.json primeiro)
#   - Diferença entre CMD e ENTRYPOINT no Dockerfile
#
# ▸ DICA:
#   Em produção, você faria um build estático (npm run build) e serviria
#   com Nginx. Mas para desenvolvimento, o dev server do Vite é perfeito.
# =============================================================================
