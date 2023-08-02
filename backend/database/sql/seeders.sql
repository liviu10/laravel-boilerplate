
-- Seed table users
INSERT INTO users (id, full_name, first_name, last_name, nickname, email, email_verified_at, phone, roles_and_permissions_id, password, profile_image, created_at, updated_at)
VALUES
(1, 'User Webmaster', 'User', 'Webmaster', 'webmaster', 'webmaster@example.com', '2023-08-02 12:34:56', NULL, 1, '123@UserWebmaster', NULL, '2023-08-02 12:34:56', '2023-08-02 12:34:56'),
(2, 'User Administrator', 'User', 'administrator', 'administrator', 'administrator@example.com', '2023-08-02 12:34:56', NULL, 2, '123@UserAdministrator', NULL, '2023-08-02 12:34:56', '2023-08-02 12:34:56'),
(3, 'User Accountant', 'User', 'Accountant', 'accountant', 'accountant@example.com', '2023-08-02 12:34:56', NULL, 3, '123@UserAccountant', NULL, '2023-08-02 12:34:56', '2023-08-02 12:34:56'),
(4, 'User Sales', 'User', 'Sales', 'sales', 'sales@example.com', '2023-08-02 12:34:56', NULL, 4, '123@UserSales', NULL, '2023-08-02 12:34:56', '2023-08-02 12:34:56'),
(5, 'User Client', 'User', 'Client', 'client', 'client@example.com', '2023-08-02 12:34:56', NULL, 5, '123@UserClient', NULL, '2023-08-02 12:34:56', '2023-08-02 12:34:56');
