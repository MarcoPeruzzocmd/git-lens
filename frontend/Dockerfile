FROM node:20-alpine

WORKDIR /app

# Copiar package.json primeiro para aproveitar o cache de layers do Docker
# (se o package.json não mudar, o npm install não roda de novo no rebuild)
COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 5173

# --host 0.0.0.0 é obrigatório para o Vite ser acessível fora do container
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0"]
