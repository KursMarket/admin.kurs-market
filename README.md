##Перенести курсы

```
INSERT INTO admin_kurs_market.courses 
(
    id, 
    title, 
    prefix, 
    school_id, 
    source_link, 
    show_in_rating, 
    study_duration, 
    price, 
    sale, 
    credit_price, 
    credit_month, 
    additional_description, 
    feed_id, 
    sort_order_in_schools, 
    sort_order_in_categories, 
    url, 
    created_at, 
    updated_at
)
SELECT 
    Id, 
    Title, 
    '', 
    OwnerId, 
    ExternalCourseLink, 
    0, 
    PeriodCount, 
    (CASE WHEN Price IS NULL THEN 0 ELSE Price END), 
    Sale, 
    (select Price from InstallmentPlans where CourseId = Id), 
    (SELECT Limitation FROM InstallmentPlans WHERE CourseId = Id), 
    Description, 
    NULL, 
    SortOrderForSchools, 
    SortOrderFoSubCategory,
    URL, 
    CreatedAt, 
    UpdatedAt 
FROM Courses 
WHERE Title IS NOT NULL 
    AND PackageName IS NULL 
    AND ParentCourseId IS NULL 
    AND URL IS NOT NULL 
ON DUPLICATE KEY UPDATE admin_kurs_market.courses.url = CONCAT(Courses.URL, '-', Courses.Id);
