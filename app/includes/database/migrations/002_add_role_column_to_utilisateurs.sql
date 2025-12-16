Alter Table utilisateurs
add column IF NOT EXISTS role ENUM ('admin', 'user') NOT NULL DEFAULT 'user'