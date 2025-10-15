INSERT INTO categorias (id, nombre)
VALUES 
(1, 'Tecnología'),
(2, 'Vehículos'),
(3, 'Hogar');

INSERT INTO anuncios (id, titulo, descripcion, direccion, precio, id_usuario, id_categoria, estado)
VALUES
(1, 'iPhone 14 Pro 256GB', 
 'Vendo iPhone 14 Pro en perfecto estado, sin rayaduras y con caja original.', 
 'Calle Mayor 12, Madrid', 
 1050.00, 
 4, 
 1, 
 TRUE),

(2, 'Coche Seat Ibiza 2018', 
 'Seat Ibiza gasolina, 80.000 km, único dueño, revisiones al día.', 
 'Avenida Andalucía 45, Sevilla', 
 8500.00, 
 5, 
 2, 
 TRUE),

(3, 'Sofá de 3 plazas gris', 
 'Sofá cómodo de tela gris, 3 plazas, casi nuevo.', 
 'Calle Gran Vía 5, Valencia', 
 220.00, 
 6, 
 3, 
 TRUE);


