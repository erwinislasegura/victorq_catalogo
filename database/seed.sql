-- ==========================================================
-- DATOS INICIALES / SEED DATA PARA VICTORQ
-- Compatible con MySQL 5.7+, 8.0+ y MariaDB (Sin error 1701)
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;

-- Limpieza segura de tablas (DELETE evita error 1701 de TRUNCATE)
DELETE FROM `activity_logs`;
DELETE FROM `quotes`;
DELETE FROM `technical_tables`;
DELETE FROM `products`;
DELETE FROM `categories`;
DELETE FROM `role_permissions`;
DELETE FROM `menus`;
DELETE FROM `users`;
DELETE FROM `roles`;

-- Resetear autoincrementables
ALTER TABLE `roles` AUTO_INCREMENT = 1;
ALTER TABLE `users` AUTO_INCREMENT = 1;
ALTER TABLE `menus` AUTO_INCREMENT = 1;
ALTER TABLE `role_permissions` AUTO_INCREMENT = 1;
ALTER TABLE `categories` AUTO_INCREMENT = 1;
ALTER TABLE `products` AUTO_INCREMENT = 1;
ALTER TABLE `technical_tables` AUTO_INCREMENT = 1;
ALTER TABLE `quotes` AUTO_INCREMENT = 1;
ALTER TABLE `activity_logs` AUTO_INCREMENT = 1;

-- 1. Roles
INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `is_system`) VALUES
(1, 'Super Administrador', 'admin', 'Acceso total y configuración del sistema', 1),
(2, 'Supervisor de Catálogo', 'supervisor', 'Gestión de productos, categorías y tablas técnicas', 1),
(3, 'Ejecutivo de Ventas', 'ventas', 'Gestión de cotizaciones y consulta de catálogo', 1),
(4, 'Operador / Consulta', 'operador', 'Acceso de solo lectura al catálogo y dashboard', 1);

-- 2. Menús del Sistema
INSERT INTO `menus` (`id`, `parent_id`, `title`, `url`, `icon`, `module_code`, `badge`, `badge_class`, `sort_order`, `is_active`) VALUES
(1, NULL, 'Dashboard', '?c=dashboard', 'bi-speedometer2', 'dashboard', NULL, 'bg-primary', 1, 1),
(2, NULL, 'Productos', '?c=product', 'bi-box-seam', 'products', '24', 'bg-info', 2, 1),
(3, NULL, 'Categorías', '?c=category', 'bi-tags', 'categories', '9', 'bg-secondary', 3, 1),
(4, NULL, 'Cotizaciones', '?c=quote', 'bi-file-earmark-text', 'quotes', 'Nuevo', 'bg-warning text-dark', 4, 1),
(5, NULL, 'Tablas Técnicas', '?c=table', 'bi-table', 'tables', '19', 'bg-success', 5, 1),
(6, NULL, 'Usuarios', '?c=user', 'bi-people', 'users', NULL, 'bg-primary', 6, 1),
(7, NULL, 'Roles y Permisos', '?c=role', 'bi-shield-lock', 'roles', NULL, 'bg-primary', 7, 1),
(8, NULL, 'Menús del Sistema', '?c=menu', 'bi-menu-button-wide', 'menus', NULL, 'bg-primary', 8, 1),
(9, NULL, 'Ver Catálogo Web', '../index.php', 'bi-globe', 'public_catalog', NULL, 'bg-dark', 9, 1);

-- 3. Permisos por Rol (RBAC)
INSERT INTO `role_permissions` (`role_id`, `menu_id`, `can_view`, `can_create`, `can_edit`, `can_delete`) VALUES
-- Admin (Acceso total a todo)
(1, 1, 1, 1, 1, 1), (1, 2, 1, 1, 1, 1), (1, 3, 1, 1, 1, 1), (1, 4, 1, 1, 1, 1), (1, 5, 1, 1, 1, 1), (1, 6, 1, 1, 1, 1), (1, 7, 1, 1, 1, 1), (1, 8, 1, 1, 1, 1), (1, 9, 1, 0, 0, 0),
-- Supervisor (Dashboard, Productos, Categorías, Tablas, Cotizaciones)
(2, 1, 1, 0, 0, 0), (2, 2, 1, 1, 1, 1), (2, 3, 1, 1, 1, 1), (2, 4, 1, 0, 1, 0), (2, 5, 1, 1, 1, 1), (2, 6, 0, 0, 0, 0), (2, 7, 0, 0, 0, 0), (2, 8, 0, 0, 0, 0), (2, 9, 1, 0, 0, 0),
-- Ventas (Dashboard, Cotizaciones con gestión, Productos y Categorías solo lectura)
(3, 1, 1, 0, 0, 0), (3, 2, 1, 0, 0, 0), (3, 3, 1, 0, 0, 0), (3, 4, 1, 1, 1, 0), (3, 5, 1, 0, 0, 0), (3, 6, 0, 0, 0, 0), (3, 7, 0, 0, 0, 0), (3, 8, 0, 0, 0, 0), (3, 9, 1, 0, 0, 0),
-- Operador (Dashboard, Productos y Tablas solo lectura)
(4, 1, 1, 0, 0, 0), (4, 2, 1, 0, 0, 0), (4, 3, 0, 0, 0, 0), (4, 4, 0, 0, 0, 0), (4, 5, 1, 0, 0, 0), (4, 6, 0, 0, 0, 0), (4, 7, 0, 0, 0, 0), (4, 8, 0, 0, 0, 0), (4, 9, 1, 0, 0, 0);

-- 4. Usuarios Iniciales (Password: password123)
INSERT INTO `users` (`id`, `role_id`, `name`, `email`, `password`, `phone`, `is_active`) VALUES
(1, 1, 'Carlos Valenzuela (Admin)', 'admin@victorq.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', '+56 9 7140 1455', 1),
(2, 2, 'Marcela Rojas (Supervisor)', 'supervisor@victorq.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', '+56 9 8234 5678', 1),
(3, 3, 'Rodrigo Soto (Ventas)', 'ventas@victorq.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', '+56 9 9123 4567', 1),
(4, 4, 'Andrés Morales (Operador)', 'operador@victorq.com', '$2y$10$EixZaYVK1fsbw1ZfbX3OXePaWxn96p36WQoeG6Lruj3vjPGga31lW', '+56 9 7890 1234', 1);

-- 5. Categorías de Productos
INSERT INTO `categories` (`id`, `slug`, `name`, `description`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'llaves', 'Llaves de Torque', 'Llaves hidráulicas de cuadrante y bajo perfil para apernado de alta precisión en minería e industria.', 'bi-wrench-adjustable', 1, 1),
(2, 'bombas', 'Bombas y Centrales', 'Centrales electrohidráulicas, neumáticas y manuales de 700 bar de alto rendimiento.', 'bi-lightning-charge', 2, 1),
(3, 'cilindros', 'Cilindros Hidráulicos', 'Cilindros de simple efecto, émbolo hueco, telescópicos y alta tonelada para levante pesado.', 'bi-bullseye', 3, 1),
(4, 'multiplicadores', 'Multiplicadores de Torque', 'Multiplicadores mecánicos y manuales para apriete y desapriete en espacios confinados.', 'bi-gear-wide-connected', 4, 1),
(5, 'bridas', 'Herramientas para Bridas', 'Separadores y alineadores de bridas hidráulicos y mecánicos para mantenimiento de tuberías.', 'bi-bounding-box-circles', 5, 1),
(6, 'cortatuercas', 'Corta Tuercas', 'Cortatuercas hidráulicos para corte seguro y rápido de tuercas trabadas o corroídas.', 'bi-scissors', 6, 1),
(7, 'extractores', 'Extractores', 'Extractores hidráulicos y mecánicos de 2 y 3 brazos para rodamientos, poleas y piñones.', 'bi-tools', 7, 1),
(8, 'prensas', 'Prensas de Taller', 'Prensas hidráulicas tipo H para montaje, desmontaje y enderezado estructural.', 'bi-hammer', 8, 1),
(9, 'accesorios', 'Accesorios', 'Acoples rápidos antigoteo, manómetros certificados y mangueras hidráulicas de 700 bar.', 'bi-sliders', 9, 1);

-- 6. Productos del Catálogo
INSERT INTO `products` (`id`, `category_id`, `model`, `name`, `description`, `image`, `specs_json`, `sort_order`, `is_featured`, `is_active`) VALUES
(1, 1, 'Serie MXTA', 'Llave de Torque Hidráulica de Cuadrante', 'Llave de Torque Hidráulica de Cuadrante de alta eficiencia industrial VICTORQ, modelo Serie MXTA.', 'prod_01_llaves.png', '{"Torque":"200 – 37.000 Lb-ple","Cuadrante":"3/4\\" a 2-1/2\\"","Presión":"700 bar","Modelos":"1,3,5,8,10,20,25,35 MXTA"}', 1, 1, 1),
(2, 1, 'Serie XLCTA (LOW)', 'Llave de Torque Bajo Perfil / Hueca', 'Llave de Torque Bajo Perfil / Hueca de alta eficiencia industrial VICTORQ, modelo Serie XLCTA (LOW).', 'prod_02_llaves.png', '{"Torque":"130 – 30.190 Lb-ple","Hexágono":"19 – 175 mm","Modelos":"2,4,8,14,30 XLCTA","Accesorios":"Ratchet intercambiable"}', 2, 1, 1),
(3, 1, 'Serie VIC', 'Llave de Torque Hidráulica de Cuadrante (Square Drive)', 'Llave de Torque Hidráulica de Cuadrante (Square Drive) de alta eficiencia industrial VICTORQ, modelo Serie VIC.', 'prod_03_llaves.png', '{"Modelos":"VIC1 a VIC50","Encastre":"Cuadrado","Ficha técnica":"Consultar rango de torque exacto"}', 3, 1, 1),
(4, 1, 'Serie TORQ', 'Llave de Torque Hidráulica de Bajo Perfil (Low Profile)', 'Llave de Torque Hidráulica de Bajo Perfil (Low Profile) de alta eficiencia industrial VICTORQ, modelo Serie TORQ.', 'prod_04_llaves.png', '{"Modelos":"TORQ2 a TORQ30 (+variantes -50/-65/-90/-115/-135/-155)","Ficha técnica":"Consultar rango de torque exacto"}', 4, 1, 1),
(5, 2, 'Bomba Electrohidráulica', 'Central Electrohidráulica VICTORQ', 'Central Electrohidráulica VICTORQ de alta eficiencia industrial VICTORQ, modelo Bomba Electrohidráulica.', 'prod_05_bombas.png', '{"Acoples":"Autotrabantes antigoteo","Manguera":"6 m","Manómetro":"Certificado","Motor":"Sin carbones ni tarjeta"}', 5, 1, 1),
(6, 2, 'TWP-200 / TWP-500P', 'Bomba Eléctrica / Neumática para Llave de Torque', 'Bomba Eléctrica / Neumática para Llave de Torque de alta eficiencia industrial VICTORQ, modelo TWP-200 / TWP-500P.', 'prod_06_bombas.png', '{"Presión de salida":"40 – 700 bar","Caudal a 700 bar":"0,8 L/min","Peso":"21 kg","Estanque":"7,6 L, aluminio"}', 6, 1, 1),
(7, 2, 'Bomba Manual', 'Bomba Manual Hidráulica', 'Bomba Manual Hidráulica de alta eficiencia industrial VICTORQ, modelo Bomba Manual.', 'prod_07_bombas.png', '{"Accionamiento":"Palanca manual","Uso":"General","Presión máx.":"700 bar"}', 7, 1, 1),
(8, 2, 'Series MD / MS / SS / SD', 'Bomba Eléctrica Hidráulica', 'Bomba Eléctrica Hidráulica de alta eficiencia industrial VICTORQ, modelo Series MD / MS / SS / SD.', 'prod_08_bombas.png', '{"Presión máx.":"700 bar","Motor":"Antiexplosivo disponible","Ficha técnica":"Consultar caudal por modelo"}', 8, 1, 1),
(9, 3, 'Serie RCH', 'Cilindro de Émbolo Hueco (Hollow Plunger)', 'Cilindro de Émbolo Hueco (Hollow Plunger) de alta eficiencia industrial VICTORQ, modelo Serie RCH.', 'prod_09_cilindros.png', '{"Tipo":"Émbolo hueco","Presión máx.":"700 bar"}', 9, 1, 1),
(10, 3, 'Serie RC', 'Cilindro de Simple Efecto de Propósito General', 'Cilindro de Simple Efecto de Propósito General de alta eficiencia industrial VICTORQ, modelo Serie RC.', 'prod_10_cilindros.png', '{"Tipo":"Simple efecto","Presión máx.":"700 bar"}', 10, 1, 1),
(11, 3, 'Serie CLSG', 'Cilindro de Alta Tonelada', 'Cilindro de Alta Tonelada de alta eficiencia industrial VICTORQ, modelo Serie CLSG.', 'prod_11_cilindros.png', '{"Capacidad":"50 – 1.000 ton","Carrera":"50 – 300 mm","Presión máx.":"700 bar"}', 11, 1, 1),
(12, 3, 'Serie TC', 'Cilindro Telescópico', 'Cilindro Telescópico de alta eficiencia industrial VICTORQ, modelo Serie TC.', 'prod_12_cilindros.png', '{"Capacidad":"10 / 15 / 30 ton","Etapas":"2 o 3","Presión máx.":"700 bar"}', 12, 1, 1),
(13, 3, 'Serie BRC / BRP', 'Cilindro Tensor (Pulling Cylinder)', 'Cilindro Tensor (Pulling Cylinder) de alta eficiencia industrial VICTORQ, modelo Serie BRC / BRP.', 'prod_13_cilindros.png', '{"Aplicación":"Tensado de cables/espárragos","Uso combinado":"Bombas Serie TORQ"}', 13, 1, 1),
(14, 3, 'Serie RAC', 'Cilindro de Aluminio de Simple Efecto', 'Cilindro de Aluminio de Simple Efecto de alta eficiencia industrial VICTORQ, modelo Serie RAC.', 'prod_14_cilindros.png', '{"Capacidad ref.":"50 ton / 496 kN (RAC-502)","Peso ref.":"8,5 kg","Acabado":"Hard-Coat"}', 14, 1, 1),
(15, 4, 'HT3 / HT4 / HT30 / HT45 / HT60 / HT1-HT13', 'Multiplicador de Torque Manual', 'Multiplicador de Torque Manual de alta eficiencia industrial VICTORQ, modelo HT3 / HT4 / HT30 / HT45 / HT60 / HT1-HT13.', 'prod_15_multiplicadores.png', '{"Tipo":"Manual, brazo de reacción integrado","Modelos":"MDS, HT3, HT4, HT52, HT72, HT30, HT45, HT60, HT1-HT13"}', 15, 1, 1),
(16, 5, 'FSM-8 / FSH-14', 'Separador de Bridas Hidráulico', 'Separador de Bridas Hidráulico de alta eficiencia industrial VICTORQ, modelo FSM-8 / FSH-14.', 'prod_16_bridas.png', '{"Fuerza máx. ref.":"8 – 14 ton","Insertos":"Intercambiables"}', 16, 1, 1),
(17, 5, 'FSW25TE / FSW25TI', 'Separador de Bridas 24 Ton', 'Separador de Bridas 24 Ton de alta eficiencia industrial VICTORQ, modelo FSW25TE / FSW25TI.', 'prod_17_bridas.png', '{"Capacidad":"24 ton","Acceso":"Desde 6 mm","Presión":"700 bar"}', 17, 1, 1),
(18, 5, 'FA-1TM / FA-4TM / FA-9TM / FA-9TE', 'Alineador de Bridas', 'Alineador de Bridas de alta eficiencia industrial VICTORQ, modelo FA-1TM / FA-4TM / FA-9TM / FA-9TE.', 'prod_18_bridas.png', '{"Tipo":"Mecánico/hidráulico","Uso":"Corrección de desalineación"}', 18, 1, 1),
(19, 6, 'HNS / DNS / NS / NC', 'Corta Tuercas Hidráulico (Nut Splitter)', 'Corta Tuercas Hidráulico (Nut Splitter) de alta eficiencia industrial VICTORQ, modelo HNS / DNS / NS / NC.', 'prod_19_cortatuercas.png', '{"Hexágono":"17 – 135 mm","Perno/Espárrago":"M10 – M95","Presión":"700 bar"}', 19, 1, 1),
(20, 7, 'Gear Pusher', 'Extractor Hidráulico de Tres Patas', 'Extractor Hidráulico de Tres Patas de alta eficiencia industrial VICTORQ, modelo Gear Pusher.', 'prod_20_extractores.png', '{"Tipo":"Hidráulico / mecánico de cruceta","Uso":"Rodamientos, poleas, engranajes"}', 20, 1, 1),
(21, 7, 'Extractor Autocentrante', 'Extractor Mecánico Autocentrante', 'Extractor Mecánico Autocentrante de alta eficiencia industrial VICTORQ, modelo Extractor Autocentrante.', 'prod_21_extractores.png', '{"Tipo":"Mecánico, 2 o 3 brazos","Uso":"Desmontaje sin dañar el eje"}', 21, 1, 1),
(22, 8, 'Serie H', 'Prensa Hidráulica de Taller', 'Prensa Hidráulica de Taller de alta eficiencia industrial VICTORQ, modelo Serie H.', 'prod_22_prensas.png', '{"Capacidad":"10 – 200 ton","Luz máx. x ancho":"1.384 x 1.219 mm","Presión máx.":"700 bar"}', 22, 1, 1),
(23, 9, 'C604 / CT901', 'Acople Rápido Antigoteo', 'Acople Rápido Antigoteo de alta eficiencia industrial VICTORQ, modelo C604 / CT901.', 'prod_23_accesorios.png', '{"Rosca":"1/4\\" – 3/8\\" NPT","Presión máx.":"700 bar"}', 23, 1, 1),
(24, 9, 'HG-63-70 / HG-100-70', 'Manómetro Hidráulico', 'Manómetro Hidráulico de alta eficiencia industrial VICTORQ, modelo HG-63-70 / HG-100-70.', 'prod_24_accesorios.png', '{"Diámetro":"63 / 100 mm","Rango":"0 – 700 bar"}', 24, 1, 1);

-- 7. Tablas Técnicas
INSERT INTO `technical_tables` (`id`, `title`, `subtitle`, `headers_json`, `rows_json`, `note`, `sort_order`, `is_active`) VALUES
(1, 'Serie MXTA — Llaves de Torque Hidráulicas de Cuadrante', '', '["Modelo", "Torque mín. (Lb-ple)", "Torque máx. (Lb-ple)", "Cuadrante", "Peso (kg)"]', '[["1 MXTA", "200", "1.390", "3/4\"", "2"], ["3 MXTA", "480", "3.280", "1\"", "2"], ["5 MXTA", "835", "5.590", "1-1/2\"", "7"], ["8 MXTA", "800", "8.000", "1-1/2\"", "91*"], ["10 MXTA", "1.755", "11.520", "1-1/2\"", "131*"], ["20 MXTA", "2.960", "19.760", "2-1/2\"", "25"], ["25 MXTA", "3.960", "25.890", "2-1/2\"", "31"], ["35 MXTA", "4.800", "37.000", "2-1/2\"", "45"]]', '', 1, 1),
(2, 'Serie XLCTA (LOW) — Llaves de Bajo Perfil / Hexágono Hueco', '', '["Modelo", "Torque mín. (Lb-ple)", "Torque máx. (Lb-ple)", "Hexágono (mm)", "Peso módulo (kg)", "Peso hexágono (kg)"]', '[["2 XLCTA", "130", "1.367", "19 – 60", "9", "15"], ["4 XLCTA", "320", "3.930", "25 – 80", "17", "34"], ["8 XLCTA", "650", "7.500", "41 – 105", "30", "63"], ["14 XLCA", "1.150", "13.020", "50 – 117", "46", "114"], ["30 XLCTA", "2.600", "30.190", "80 – 175", "104", "205"]]', '', 2, 1),
(3, 'Serie VIC / TORQ — Modelos por Capacidad', '', '["Serie VIC (cuadrante)", "Serie TORQ (bajo perfil)"]', '[["VIC 1", "TORQ 2 / TORQ 2-50"], ["VIC 3", "TORQ 4 / TORQ 4-65"], ["VIC 5", "TORQ 8 / TORQ 8-90"], ["VIC 8", "TORQ 14 / TORQ 14-115"], ["VIC 10", "TORQ 18 / TORQ 18-135"], ["VIC 15", "TORQ 30 / TORQ 30-155"], ["VIC 20 / VIC 25 / VIC 35 / VIC 50", "—"]]', '', 3, 1),
(4, 'Bomba Eléctrica / Neumática para Llave de Torque (TWP)', '', '["Parámetro", "Valor"]', '[["Caudal de aceite a 700 bar", "0,8 L/min"], ["Caudal de aceite a 300 bar", "1,6 L/min"], ["Caudal de aceite a 70 bar", "8 L/min"], ["Capacidad de estanque", "7,6 L"], ["Rango de presión de aire (versión neumática)", "4 – 8 bar"], ["Peso", "21 kg"]]', '', 4, 1),
(5, 'Bomba Electrohidráulica VICTORQ', '', '["Característica", "Detalle"]', '[["Acoples", "Autotrabantes antigoteo"], ["Enfriamiento", "Radiador"], ["Válvula de alivio", "Sí, regulable"], ["Motor", "Sin carbones ni tarjeta electrónica"], ["Manómetro", "Certificado"], ["Manguera", "6 metros"]]', '', 5, 1),
(6, 'Bomba Eléctrica (Series MD / MS / SS / SD)', '', '[]', '[]', '', 6, 1),
(7, 'Serie CLSG — Cilindro de Alta Tonelada', '', '["Modelo", "Capacidad", "Carrera", "Área efectiva", "Cap. de aceite", "Altura colapsada", "Peso"]', '[["CLSG-502", "50 ton / 539 kN", "50 mm", "77,0 cm²", "385 cm³", "162 mm", "17 kg"], ["CLSG-100012", "1.000 ton / 10.260 kN", "300 mm", "1.465,7 cm²", "43.972 cm³", "814 mm", "1.439 kg"]]', '', 7, 1),
(8, 'Cilindro Telescópico (TC)', '', '["Modelo", "Capacidad", "Etapas"]', '[["TC10-2 / TC10-3", "10 ton", "2 / 3"], ["TC15-2 / TC15-3", "15 ton", "2 / 3"], ["TC30-2 / TC30-3", "30 ton", "2 / 3"]]', '', 8, 1),
(9, 'Serie RAC — Cilindro de Aluminio de Simple Efecto', '', '["Modelo", "Capacidad", "Área efectiva", "Cap. de aceite", "Altura", "Diám. exterior", "Peso"]', '[["RAC-502", "50 ton / 496 kN", "70,9 cm²", "354 cm³", "186 mm", "130 mm", "8,5 kg"]]', '', 9, 1),
(10, 'RC / RCH / BRC-BRP — Otras Series de Cilindro', '', '["Serie", "Descripción"]', '[["RC", "Cilindro de simple efecto de propósito general"], ["RCH", "Cilindro de émbolo hueco (Hollow Plunger)"], ["BRC / BRP", "Cilindro tensor (Pulling Cylinder), uso combinado con bombas serie TORQ"]]', '', 10, 1),
(11, 'Multiplicador de Torque Manual (Manual Torque Multiplier)', '', '[]', '[]', '', 11, 1),
(12, 'Separador de Bridas 24 Ton — FSW25TE / FSW25TI', '', '["Modelo", "Tipo", "Presión de trabajo"]', '[["FSW25TE", "Externo", "700 bar"], ["FSW25TI", "Integral", "700 bar"]]', '', 12, 1),
(13, 'Separador de Bridas — Cabezales FSM-8 / FSH-14', '', '["Modelo", "Fuerza máxima aprox."]', '[["FSM-8", "8 ton"], ["FSH-14", "14 ton"]]', '', 13, 1),
(14, 'Alineador de Bridas (Flange Alignment Tool)', '', '["Modelo"]', '[["FA-1TM"], ["FA-4TM"], ["FA-9TM"], ["FA-9TE"]]', '', 14, 1),
(15, 'Corta Tuercas Hidráulico — Integral (HNS) y Doble Efecto (DNS)', '', '["Modelo", "Hexágono", "Perno / Espárrago", "Peso"]', '[["HNS2432", "17 – 32 mm (11/16 – 1 1/4\")", "M10 – M22 (1/2 – 3/4\")", "5 kg"], ["HNS3241", "32 – 41 mm (1 1/4 – 1 5/8\")", "M22 – M27 (3/4 – 1\")", "7 kg"], ["HNS4150", "41 – 50 mm (1 5/8 – 2\")", "M27 – M33 (1 – 1 1/4\")", "11 kg"], ["DNS75105", "75 – 105 mm (2 15/16 – 4 1/4\")", "M48 – M72", "51 kg"], ["DNS105135", "105 – 135 mm (4 1/4 – 5 3/8\")", "M72 – M95", "98 kg"]]', '', 15, 1),
(16, 'Extractores — Familia Completa', '', '["Modelo / Tipo", "Descripción"]', '[["Gear Pusher", "Extractor hidráulico de tres patas"], ["Extractor de cruceta", "Extractor mecánico de cruceta"], ["Integral Puller / Cobra Puller", "Extractor mecánico integral, mordazas autocentrantes"], ["YL-Series", "Extractor hidráulico de tres garras (split)"], ["Extractor autocentrante", "Mecánico, dos o tres brazos"], ["Extractor hidráulico separado", "Separated Hydraulic Puller"]]', '', 16, 1),
(17, 'Prensa Hidráulica de Taller Serie H', '', '["Capacidad", "Modelos asociados"]', '[["10 ton", "IPE-1215 / IPH-1240 / IPH-1234"], ["25 ton", "IPE-2505 / IPE-2510 / IPH-2531"], ["30 ton", "IPE-3060 / IPH-3080"], ["50 ton", "IPE-5010 / IPH-5030 / IPH-5031 / IPE-5005 / IPE-5060 / IPH-5080"], ["100 ton", "IPE-10010 / IPH-10030 / IPE-10060 / IPH-10080"], ["150 ton", "IPE-15065"], ["200 ton", "IPE-20065"]]', '', 17, 1),
(18, 'Acople Rápido Antigoteo (Quick Coupling)', '', '["Modelo", "Hembra", "Macho", "Rosca"]', '[["C604", "CR604", "CH604", "3/8\" NPT"], ["CT901", "C901", "T901", "1/4\" NPT"]]', '', 18, 1),
(19, 'Manómetro Hidráulico (Hydraulic Gauge)', '', '["Modelo", "Diámetro", "Rosca", "Rango de presión"]', '[["HG-63-70", "63 mm", "NPT 1/4\"", "0 – 700 bar"], ["HG-100-70", "100 mm", "G 1/2", "0 – 700 bar"]]', '', 19, 1);

-- 8. Cotizaciones de Ejemplo
INSERT INTO `quotes` (`id`, `product_id`, `client_name`, `client_email`, `client_phone`, `company`, `product_interest`, `message`, `status`, `admin_notes`, `created_at`) VALUES
(1, 1, 'Esteban Morales', 'emorales@mineraescondida.cl', '+56 9 8765 4321', 'Minera Escondida Ltda.', 'Llave de Torque Hidráulica Serie MXTA (10 MXTA)', 'Requerimos cotización de 2 unidades con calibración certificada y manguera de 6m.', 'pending', 'Cliente prioritario sector minería.', NOW() - INTERVAL 2 HOUR),
(2, 5, 'Claudia Fuentes', 'cfuentes@anglochile.cl', '+56 9 7654 3210', 'Anglo American Chile', 'Central Electrohidráulica VICTORQ 700 bar', 'Solicitamos cotización para proyecto de mantención en concentradora.', 'in_review', 'Contactada vía teléfono, se enviará propuesta formal hoy.', NOW() - INTERVAL 1 DAY),
(3, 19, 'Jorge Valenzuela', 'jvalenzuela@codelco.cl', '+56 9 6543 2109', 'Codelco División Andina', 'Corta Tuercas Hidráulico HNS / DNS', 'Cotizar modelo para pernos M36 y M48 con juego de cuchillas de repuesto.', 'quoted', 'Cotización N° VQ-2026-089 enviada por correo.', NOW() - INTERVAL 3 DAY);

SET FOREIGN_KEY_CHECKS = 1;