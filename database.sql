CREATE TABLE tb_category (
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR (20) NOT NULL
);


CREATE TABLE tb_beverage (
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    category_id INT (11),
    title VARCHAR(50) NOT NULL,
    description VARCHAR(100),
    quantity INT (11) NOT NULL,
    price FLOAT(10,2) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES tb_category(id)
);



INSERT INTO tb_category(name) VALUES 
('Cachaça'),
('Cerveja'),
('Whisky'),
('Energético');

