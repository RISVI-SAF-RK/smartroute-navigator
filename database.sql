CREATE DATABASE IF NOT EXISTS smartroute_navigator;
USE smartroute_navigator;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

CREATE TABLE places (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    location_name VARCHAR(255),
    distance_km DECIMAL(5,2),
    recommended_time VARCHAR(100),
    visit_duration VARCHAR(100),
    tips TEXT,
    image_url TEXT,
    map_embed_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    user_email VARCHAR(150),
    rating INT NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE trip_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(100) NOT NULL,
    start_point VARCHAR(255) NOT NULL,
    start_time VARCHAR(20),
    trip_type VARCHAR(100),
    selected_places TEXT NOT NULL,
    total_distance DECIMAL(8,2) DEFAULT 0,
    status ENUM('Current','Completed') DEFAULT 'Current',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$x4hoJQdVLV0zCEfNv6Tr1uK0BsA5IdhruuS.4zF4gzCjJYOZK6Kc6');
INSERT INTO categories (name, description) VALUES
('Religious', 'Sacred and religious places in the Mihintale area'),
('Nature', 'Natural attractions and scenic places'),
('Heritage', 'Historical and archaeological places'),
('Cultural', 'Culturally significant places');

INSERT INTO places (
    category_id, name, description, location_name, distance_km,
    recommended_time, visit_duration, tips, image_url, map_embed_url
) VALUES
(
    1,
    'Mihintale Raja Maha Viharaya',
    'One of the most sacred Buddhist places in Sri Lanka. It is known as the location where Arahat Mahinda met King Devanampiyatissa, marking the introduction of Buddhism to Sri Lanka.',
    'Mihintale Main Temple Area',
    10.00,
    'Early Morning / Evening',
    '45 Minutes',
    'Wear modest clothing, carry water, and start early in the morning.',
    'https://images.unsplash.com/photo-1524492412937-b28074a5d7da?auto=format&fit=crop&w=1200&q=80',
    'https://www.google.com/maps?q=Mihintale&output=embed'
),
(
    2,
    'Kaludiya Pokuna',
    'A peaceful natural attraction with a calm environment, forest surroundings, and archaeological significance.',
    'Near Mihintale',
    11.00,
    'Morning',
    '30 Minutes',
    'Best visited in cool weather. Wear comfortable shoes.',
    'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
    'https://www.google.com/maps?q=Kaludiya+Pokuna&output=embed'
),
(
    3,
    'Mihintale Archaeological Museum',
    'An educational site displaying statues, inscriptions, ancient tools, and historical artifacts related to Mihintale civilization.',
    'Near Mihintale Entrance',
    10.00,
    'Morning / Afternoon',
    '30 Minutes',
    'Take time to read the information displays for better understanding.',
    'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=1200&q=80',
    'https://www.google.com/maps?q=Mihintale+Archaeological+Museum&output=embed'
),
(
    1,
    'Ambasthala Dagoba',
    'A highly important religious site believed to mark the exact location of the historic meeting between Arahat Mahinda and King Devanampiyatissa.',
    'Summit of Mihintale Rock',
    10.00,
    'Morning',
    '30 Minutes',
    'Ideal to visit after the main temple. Carry water.',
    'https://images.unsplash.com/photo-1548013146-72479768bada?auto=format&fit=crop&w=1200&q=80',
    'https://www.google.com/maps?q=Ambasthala+Dagoba&output=embed'
),
(
    3,
    'Lion Rock (Sinhagala)',
    'An important heritage point with carved stone steps and a scenic elevated viewpoint.',
    'Mihintale Temple Complex',
    10.00,
    'Morning / Evening',
    '20 Minutes',
    'Use proper footwear and take care while climbing.',
    'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
    'https://www.google.com/maps?q=Lion+Rock+Mihintale&output=embed'
);