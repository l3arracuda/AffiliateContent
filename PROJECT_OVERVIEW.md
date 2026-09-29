# AffiliateContent Project Overview

## 1. Project Name

**AffiliateContent**

Project root:

`D:\CodeX\AffiliateContent`

---

# 2. Project Purpose

โปรเจกต์นี้มีเป้าหมายเพื่อสร้างระบบสำหรับทำธุรกิจ **Shopee Affiliate แบบเป็นระบบ**

ระบบต้องช่วยตั้งแต่:

- ค้นหาและคัดเลือกสินค้า
- ตรวจสอบว่าสินค้ามี EXTRA COMM
- เก็บ Affiliate Link
- เก็บและดาวน์โหลดรูปสินค้า
- วิเคราะห์ว่าสินค้าไหนน่าทำ Content
- สร้างแนวคิด Content
- สร้าง Image Post
- สร้าง AI Video Content
- จัดการ Content หลายเพจ
- ทดสอบตลาดก่อนซื้อสินค้าจริง
- เลือกสินค้าที่มีแนวโน้มขายได้
- สั่งซื้อสินค้าจริง
- ทำ Real Product Review
- เก็บผลลัพธ์
- เรียนรู้ว่า Content และสินค้าแบบใดทำเงินได้
- Scale สินค้าและ Content ที่ทำงานได้ดี

เป้าหมายระยะยาวคือสร้างระบบที่ทำหน้าที่เป็น:

**Shopee Affiliate Market Watch + Affiliate Content Factory + Performance Intelligence System**

---

# 3. Team Working Concept

โปรเจกต์นี้ใช้แนวทางการทำงานร่วมกันดังนี้

## ChatGPT

บทบาท:

**Planner / System Analyst / Architect**

หน้าที่:

- วางแผนระบบ
- วิเคราะห์ Business Workflow
- ออกแบบ Feature
- แตกงานออกเป็น Phase
- เตรียม Prompt สำหรับ Codex
- วิเคราะห์ Feedback จาก Work
- ปรับ Requirement
- วาง Roadmap
- ช่วยตัดสินใจเรื่อง Architecture

ChatGPT ไม่ใช่ผู้ Coding หลักของโปรเจกต์

---

## Codex

บทบาท:

**Developer / Coding / Doing**

หน้าที่:

- เขียน Code
- สร้าง Web Application
- Database
- Migration
- Seeder
- Backend
- Frontend
- Integration
- Testing
- Bug Fix
- Refactoring
- Documentation
- Git
- GitHub
- Versioning

Codex ต้องทำงานตาม Requirement และ Phase ที่กำหนด

---

## Work / Cowork

บทบาท:

**QA / Tester / UX Reviewer**

หน้าที่:

- เปิด Web Application
- ทดลองใช้งานจริง
- ทดสอบ Workflow
- ทดสอบ Functional Requirement
- ตรวจ UX
- ตรวจปัญหาการใช้งาน
- ตรวจ Bug
- ตรวจ Edge Case
- ให้ Feedback
- Regression Test หลัง Codex แก้ไข

Work ต้องทดสอบระบบจากมุมของผู้ใช้งานจริง ไม่ใช่เพียงตรวจ Code

---

# 4. Core Philosophy

ระบบนี้ต้องช่วยลดงาน Manual ที่ไม่สร้างรายได้โดยตรง เช่น:

- หา Product ทีละตัว
- ตรวจ Extra Comm ทีละตัว
- Copy Affiliate Link ทีละตัว
- Save รูปทีละรูป
- คิด Hook ใหม่ทุกครั้ง
- เขียน Caption ใหม่ทุกครั้ง
- คิด Script ใหม่ทุกครั้ง
- ติดตามสินค้าแบบ Manual
- จดข้อมูลกระจัดกระจาย

ระบบควรเปลี่ยน Workflow จาก:

`Search → Check → Copy → Save → Think → Create`

ให้เป็น:

`Watch → Select → Generate → Produce → Publish → Measure → Learn`

---

# 5. Core Business Workflow

ภาพรวมหลักของระบบ:

```text
Shopee Product Market
        ↓
Market Watch
        ↓
Filter Products
        ↓
EXTRA COMM Only
        ↓
Affiliate Link
        ↓
Product Images
        ↓
Product Analysis
        ↓
Opportunity Score
        ↓
Select Products
        ↓
Content Production
        ↓
Publish
        ↓
Performance Tracking
        ↓
Find Winners
        ↓
Order Real Product
        ↓
Real Product Content
        ↓
Sales / Conversion
        ↓
Learn
        ↓
Scale
        ↓
Feedback to Market Watch
```

---

# 6. Critical Product Requirements

สินค้าที่จะเข้าสู่ Main Affiliate Workflow ต้องมีเงื่อนไขสำคัญดังนี้

## Requirement 1 — EXTRA COMM

สินค้าที่ระบบเลือกมาทำ Affiliate ต้องมี:

**EXTRA COMM**

นี่เป็น Hard Requirement

ไม่ใช่แค่ Factor สำหรับให้คะแนน

Logic หลัก:

```text
IF has_extra_comm = false
    Reject from main opportunity list
```

สินค้าไม่มี EXTRA COMM อาจถูกเก็บข้อมูลไว้ได้ แต่ต้องไม่ถูกเสนอเป็น Main Opportunity

---

## Requirement 2 — Affiliate Link

สินค้าต้องรองรับ:

- Product URL
- Affiliate URL

ผู้ใช้ต้องสามารถ:

- เปิด Product URL
- Copy Affiliate Link

เป้าหมายในอนาคตคือให้ Affiliate Link พร้อมใช้งานโดยไม่ต้องสร้าง Manual ทีละ Product

---

## Requirement 3 — Product Images

สินค้าต้องรองรับการเก็บ Product Images

อย่างน้อย:

- Main Image
- Gallery Images

ผู้ใช้ต้องสามารถ:

- Preview
- Download Main Image
- Download Multiple Images
- Download All Images
- ใช้ภาพต่อใน Content Production

---

# 7. Market Watch

Market Watch คือ Core Module สำคัญที่สุดของระบบ

หน้าที่:

- เก็บรายการสินค้า
- ติดตามข้อมูลสินค้า
- เก็บ Snapshot
- ตรวจการเปลี่ยนแปลง
- หา Rising Product
- หา Product Opportunity
- แสดงสินค้าให้ผู้ใช้เลือก

ข้อมูลที่ควรติดตาม:

- Product Name
- Product ID
- Category
- Shop
- Product URL
- Affiliate URL
- Price
- Sale Price
- Rating
- Review Count
- Sold Count
- Base Commission
- Extra Commission
- EXTRA COMM Status
- Images
- Opportunity Score
- Product Status
- Snapshot Date

---

# 8. Historical Product Data

ระบบควรเก็บ Snapshot ของ Product เป็นระยะ

ตัวอย่าง:

```text
Day 1
Sold: 1,800

Day 3
Sold: 2,200

Day 7
Sold: 3,500
```

จากข้อมูลนี้ระบบในอนาคตสามารถคำนวณ:

- Sales Growth
- Review Growth
- Price Movement
- Commission Change
- Extra Commission Change
- Product Velocity
- Trend

---

# 9. Opportunity Scoring

ระบบจะมี Product Opportunity Score เพื่อช่วยจัดลำดับความสำคัญ

Conceptual Score:

```text
Demand
Commission
Extra Commission
Rating
Reviews
Price
Sales Growth
Content Potential
Impulse Buy Potential
Competition
Seasonality
Trend
```

EXTRA COMM ต้องเป็น Eligibility Requirement ก่อนเข้าสู่ Scoring หลัก

ไม่ใช่เพียงคะแนนเพิ่ม

---

# 10. Product Lifecycle

Product ต้องมีสถานะเพื่อใช้ติดตาม Workflow

Suggested Status:

```text
discovered
rejected
watching
pre_test
testing
winner
ordered
received
real_review
scaling
archived
```

Business Flow:

```text
DISCOVERED
    ↓
PRE-TEST
    ↓
CONTENT RUNNING
    ↓
DATA COLLECTING
    ↓
WINNER
    ↓
ORDER PRODUCT
    ↓
PRODUCT RECEIVED
    ↓
REAL REVIEW
    ↓
SCALE
```

---

# 11. Content Strategy

ระบบนี้ใช้ Content 3 รูปแบบหลัก

## Type 1 — Image Post

ใช้:

- Product Image
- Caption
- Hook
- Problem
- Benefit
- CTA
- Affiliate Link

สามารถผลิตได้ทันทีโดยไม่ต้องรอสินค้าจริง

---

## Type 2 — AI Video

ใช้:

- Product Information
- Product Images
- AI Script
- Shot List
- AI Image Prompt
- AI Video Prompt

สามารถผลิตได้ทันทีหลังพบ Product

ไม่ต้องรอสินค้าจริง

---

## Type 3 — Real Product Review

ทำหลังสินค้าได้รับการพิสูจน์แล้วว่า:

- มี Interest
- มี Click
- มี Order
- หรือมี Potential สูง

จากนั้นจึง:

- Order Product
- รับ Product
- ทดลองใช้จริง
- ถ่าย Content จริง
- รีวิวจริง
- Demonstration จริง

Real Content เป็น Content ระดับความน่าเชื่อถือสูงที่สุดของระบบ

---

# 12. Five Page Strategy

ระบบเริ่มต้นรองรับ 5 Page

4 Page แรกใช้สำหรับ Pre-Test

Page ที่ 5 ใช้สำหรับ Real Product

---

## Page 1 — Image Content

Content Style:

**Problem → Solution**

ตัวอย่างแนว:

- ปัญหาที่คนเจอบ่อย
- สินค้านี้ช่วยอย่างไร
- ทำไมควรลอง
- CTA

---

## Page 2 — Image Content

Content Style:

**Deal / Value / Feature**

เน้น:

- ความคุ้ม
- ราคา
- Feature
- Benefit
- Deal
- Extra Commission Product

สินค้าอาจเหมือน Page 1 แต่ Content Angle ต้องต่างกัน

---

## Page 3 — AI Video

Content Style:

**Story / Problem → Solution**

ตัวอย่าง:

```text
Situation
↓
Problem
↓
Pain
↓
Product
↓
Solution
↓
Result
↓
CTA
```

---

## Page 4 — AI Video

Content Style:

**Visual Demo / Before → After**

ตัวอย่าง:

```text
Hook
↓
Before
↓
Demo
↓
After
↓
Benefit
↓
CTA
```

---

## Page 5 — Personal / Real Product

Content Style:

**Real Use / Real Review / Real Demonstration**

เป็นเพจหรือ Identity ที่ผู้ใช้:

- ถือสินค้า
- ใช้สินค้า
- ทดลองสินค้า
- รีวิวสินค้า
- พูดจากประสบการณ์จริง

---

# 13. Important Content Rule

สินค้าเดียวกันสามารถขายในหลาย Page ได้

แต่ห้ามใช้แนวคิด:

**Copy & Paste Content เดิม 4 Page**

ต้องแตก Content Angle

ตัวอย่าง Product เดียว:

```text
Page 1
Problem / Solution

Page 2
Price / Value

Page 3
AI Story

Page 4
Visual Demo

Page 5
Real Review
```

ดังนั้น:

**Same Product ≠ Same Content**

---

# 14. Pre-Test Strategy

ระบบต้องช่วยลดความเสี่ยงการซื้อสินค้าเกินจำเป็น

Workflow:

```text
Find 20 Products
↓
Create Image + AI Content
↓
Publish
↓
Collect Performance
↓
Find Winners
↓
Order only Winner Products
↓
Create Real Content
```

เป้าหมาย:

ไม่ซื้อสินค้า 20 ตัวเพื่อทดลอง

แต่ทดลอง Content ก่อน แล้วอาจซื้อจริงเพียง 3–5 ตัวที่มี Potential สูง

---

# 15. Content Factory Concept

สินค้าหนึ่งตัวสามารถสร้าง Content หลายชิ้น

ตัวอย่าง:

```text
Product #001
      ↓

Page 1
Image Post #1

Page 2
Image Post #2

Page 3
AI Video #1

Page 4
AI Video #2

Product Arrives

Page 5
Real Review #1
Real Review #2
Real Demo #1
```

และสามารถสร้าง Hook หลายแบบจาก Product เดียวได้

ดังนั้น 1 Product อาจสร้างได้:

- 5 Content
- 10 Content
- 15 Content
- หรือมากกว่า

---

# 16. Batch Production

ระบบต้องออกแบบมาเพื่อรองรับ Batch Workflow

ไม่ใช่ทำ Product ทีละตัวอย่างเดียว

ตัวอย่าง:

```text
Select 10 Products
↓
Analyze 10 Products
↓
Generate 100 Hooks
↓
Select 20 Hooks
↓
Generate 20 Scripts
↓
Production Queue
↓
Batch Production
```

เป้าหมายคือประหยัดเวลาและเพิ่ม Output

---

# 17. Content Matrix

ระบบควรสามารถแสดงว่า Product หนึ่งถูกสร้าง Content ที่ไหนแล้วบ้าง

ตัวอย่าง:

```text
               IMAGE     AI VIDEO     REAL

Page 1           ✓
Page 2           ✓
Page 3                       ✓
Page 4                       ✓
Personal                                  ○
```

`✓` = ทำแล้ว

`○` = ยังไม่ได้ทำ

---

# 18. Performance Tracking

ระยะถัดไป ระบบควรเก็บผล Content

ตัวอย่างข้อมูล:

- Views
- Reach
- Watch Time
- Clicks
- CTR
- Orders
- GMV
- Commission
- Conversion Rate
- Content Type
- Content Angle
- Hook
- Product

เป้าหมายไม่ใช่รู้แค่ว่า:

“สินค้าอะไรขายดี”

แต่ต้องเรียนรู้ว่า:

“สินค้าอะไรขายดีสำหรับ Audience ของเรา”

---

# 19. Learning Loop

ระบบต้องมี Feedback Loop

ตัวอย่าง:

```text
Product A

Image Content
Orders = 12

AI Video
Orders = 2

Real Review
Orders = 18
```

ระบบในอนาคตควรรู้ว่า:

Product A เหมาะกับ:

- Image
- Real Demonstration

และอาจไม่จำเป็นต้องลงทุนสร้าง AI Video เพิ่ม

อีก Product อาจตรงกันข้าม

---

# 20. Long-Term Intelligence

ในอนาคตระบบควรตอบคำถามได้ เช่น:

- หมวดสินค้าไหนขายดีที่สุดสำหรับเรา
- ราคาเท่าไร Conversion ดีที่สุด
- Extra Commission ระดับไหนคุ้ม
- Hook แบบใดขายดีที่สุด
- Content Style ไหนเหมาะกับ Product Category ไหน
- Page ไหนขาย Product แบบไหนดีที่สุด
- AI Content หรือ Real Content ให้ ROI ดีกว่า
- Product แบบไหนควรซื้อมารีวิวจริง
- Product ไหนควร Scale
- Product ไหนควรหยุด

---

# 21. Dashboard Concept

Dashboard ระยะยาวควรแสดงข้อมูลสำคัญ เช่น:

```text
AFFILIATE COMMAND CENTER

Products Found
Extra Comm Products
Ready for Content
Currently Testing
Winner Products
Ordered Products
Received Products
Real Reviews
Scaling Products

Revenue
Commission
Orders
Conversion

Top Products
Top Pages
Top Content Types
Top Hooks
```

---

# 22. Core Modules

ระบบในอนาคตประกอบด้วย Module หลัก:

```text
Dashboard

Market Watch

Products

Opportunities

Product Analysis

Content Studio

Production Queue

Pages

Publishing

Performance

Analytics

Settings
```

ไม่จำเป็นต้องสร้างทั้งหมดใน Phase แรก

ให้สร้างตาม Roadmap ทีละ Phase

---

# 23. Initial Development Principle

การพัฒนาต้องใช้แนวคิด:

**Small Phase → Test → Fix → Commit → Next Phase**

ห้ามสร้างระบบทั้งหมดครั้งเดียว

Workflow:

```text
ChatGPT
Plan Phase

↓

Codex
Develop Phase

↓

Automated Tests

↓

Work
Functional / UX Test

↓

Feedback

↓

Codex
Fix

↓

Work
Regression Test

↓

PASS

↓

Git Commit / Version

↓

Next Phase
```

---

# 24. Definition of Done

Phase ใดจะถือว่าเสร็จเมื่อ:

```text
Code Complete
+
Application Runs
+
Migration Pass
+
Automated Tests Pass
+
Functional Test Pass
+
Work QA Pass
+
User Acceptance
=
PHASE COMPLETE
```

Codex บอกว่า "Done" เพียงอย่างเดียวไม่ถือว่า Phase Complete

---

# 25. Git and Version Control

โปรเจกต์ต้องใช้ Git ตั้งแต่เริ่ม

ทุก Phase ต้องมี Commit

ตัวอย่าง:

```text
v0.1.0
Phase 0

v0.2.0
Phase 1

v0.2.1
Bug Fix

v0.3.0
Phase 2
```

ห้ามแก้ระบบจำนวนมากโดยไม่มี Version Control

---

# 26. GitHub Strategy

เป้าหมายคือให้ Project สามารถ Push ไป GitHub

ทุก Phase ควรมี:

- Commit
- Version
- Changelog
- Test Result

เพื่อให้สามารถย้อนกลับ Version ได้

---

# 27. Logging

ระบบควรมี Logging สำหรับ Action สำคัญ

ตัวอย่าง:

- Product Imported
- Product Updated
- Product Rejected
- Product Status Changed
- Affiliate Link Created
- Affiliate Link Copied
- Image Downloaded
- Content Created
- Content Published
- Product Ordered

ระบบ Logging ไม่ควรซับซ้อนเกินความจำเป็นใน Phase แรก

---

# 28. Safety and Stability

ระบบต้อง:

- ไม่ hardcode Password
- ไม่ hardcode API Key
- ไม่ Commit Secret
- ใช้ `.env`
- มี `.env.example`
- Validate Input
- Handle Null Data
- Handle Missing Images
- Handle Missing Affiliate Link
- Handle Missing Commission
- Handle Network Failure
- มี Error Message ที่เข้าใจได้

---

# 29. External Integration Principle

ก่อนเชื่อม External Platform จริง ต้องตรวจสอบ:

- Official API
- Authentication
- Rate Limits
- Terms of Service
- Permission
- Data Availability

ห้ามสร้าง Scraping หรือ Automation แบบเสี่ยงโดยไม่ตรวจสอบก่อน

---

# 30. Shopee Integration

Shopee Integration เป็น Phase หลังจาก Foundation พร้อมแล้ว

สิ่งที่ต้องศึกษาก่อน Integration จริง:

- Product Data Source
- Affiliate Product Access
- EXTRA COMM Data
- Affiliate Link Generation
- Product Images
- Commission Data
- Sales Data
- Performance Data

Phase แรกสามารถใช้ Mock Data ได้

---

# 31. AI Integration

AI จะถูกใช้สำหรับ:

- Product Analysis
- Target Audience
- Pain Point
- Benefits
- Content Angle
- Hook
- Caption
- Script
- Image Prompt
- Video Prompt

AI Integration จริงไม่จำเป็นใน Phase 0

สามารถสร้าง Interface / Placeholder ไว้ก่อน

---

# 32. Image Content Workflow

Future Workflow:

```text
Product
↓
Product Images
↓
AI Analysis
↓
Choose Content Angle
↓
Generate Hook
↓
Generate Caption
↓
Select Image
↓
Create Post
↓
Affiliate Link
↓
Ready to Publish
```

---

# 33. AI Video Workflow

Future Workflow:

```text
Product
↓
Analysis
↓
Story Angle
↓
Hook
↓
Script
↓
Scene Breakdown
↓
Image Prompt
↓
Video Prompt
↓
Production
↓
Affiliate Link
↓
Publish
```

---

# 34. Real Product Workflow

Future Workflow:

```text
Winner Product
↓
Order Product
↓
Waiting for Delivery
↓
Received
↓
Test Product
↓
Create Real Review
↓
Film
↓
Edit
↓
Publish
↓
Measure Conversion
```

---

# 35. Order Decision

ระบบในอนาคตควรช่วยตัดสินว่า Product ไหนควรซื้อมารีวิวจริง

Possible Factors:

- Clicks
- CTR
- Orders
- Conversion
- Opportunity Score
- Commission
- Product Cost
- Content Performance
- Trend
- Real Review Potential

---

# 36. Main Business Objective

เป้าหมายไม่ใช่:

**สร้างเว็บที่มี Feature เยอะ**

เป้าหมายคือ:

**สร้างระบบที่ช่วยให้ผู้ใช้ผลิต Affiliate Content ได้เร็วขึ้น เลือกสินค้าได้ดีขึ้น ทดลองได้มากขึ้น และเสียเวลาทำงาน Manual น้อยลง**

---

# 37. Main Success Metrics

ตัวชี้วัดความสำเร็จของระบบในอนาคต:

- Time to Find Product
- Time to Prepare Content
- Products Tested per Week
- Contents Produced per Week
- Affiliate Clicks
- Orders
- Conversion Rate
- Commission
- Revenue per Product
- Revenue per Content
- Winner Rate
- Cost per Winner
- Real Review Conversion

---

# 38. Important UX Principle

ระบบต้องออกแบบให้ผู้ใช้เปิด Dashboard แล้วตอบได้รวดเร็วว่า:

> วันนี้ควรทำสินค้าอะไร?

และจากสินค้า 1 ตัว ต้องสามารถไปถึง:

```text
Product
↓
Affiliate Link
↓
Images
↓
Hook
↓
Caption / Script
↓
Production
```

โดยใช้ Click ให้น้อยที่สุดเท่าที่สมเหตุสมผล

---

# 39. Initial User Environment

Project directory:

`D:\CodeX\AffiliateContent`

Primary development environment:

- Windows
- VS Code
- Codex
- Git
- GitHub

Application จะพัฒนาเป็น Web Application

Desktop เป็น Primary UI

แต่ควร Responsive สำหรับ Mobile ด้วย

---

# 40. Initial Preferred Technology

Current preferred stack:

Backend:

- Laravel 12
- PHP 8.3+
- MySQL / MariaDB

Frontend:

- Laravel Blade หรือ Livewire
- Tailwind CSS หรือ Bootstrap

หลักการคือ:

**Maintainable > Complex**

ไม่ควรใช้ Architecture ที่ซับซ้อนเกินความจำเป็น

Technology สามารถปรับได้หากมีเหตุผลทาง Technical ที่ชัดเจน

---

# 41. Development Roadmap

Roadmap ปัจจุบันในระดับสูง:

## Phase 0

Project Bootstrap & Architecture

เป้าหมาย:

สร้าง Foundation

ยังไม่เชื่อม Shopee จริง

---

## Phase 1

Product / Market Watch Core

เป้าหมาย:

เริ่มระบบ Product Discovery และ Market Watch

รายละเอียด Phase จะกำหนดภายหลังจาก Phase 0 ผ่าน QA

---

## Phase 2

Shopee / Affiliate Data Integration

เป้าหมาย:

เริ่มเชื่อม Data Source ที่สามารถใช้งานได้จริง

ต้องตรวจสอบวิธี Integration ก่อน

---

## Phase 3

Opportunity Intelligence

เป้าหมาย:

Scoring / Growth / Ranking / Winner Detection

---

## Phase 4

Content Studio

เป้าหมาย:

Image Post / Hook / Caption / AI Script

---

## Phase 5

AI Video Workflow

เป้าหมาย:

Script → Scene → Prompt → Production Queue

---

## Phase 6

Multi-Page Content Management

เป้าหมาย:

บริหาร 5 Page และ Content Matrix

---

## Phase 7

Performance Tracking

เป้าหมาย:

เก็บผล Content / Click / Order / Commission

---

## Phase 8

Winner → Real Product Workflow

เป้าหมาย:

Order / Receive / Real Review / Scale

---

## Phase 9+

Automation / Analytics / Intelligence / Scaling

รายละเอียดกำหนดจากข้อมูลจริงหลังระบบเริ่มใช้งาน

---

# 42. Change Management

ไฟล์นี้คือ:

**Project-Wide Source of Truth**

Codex ต้องอ่านไฟล์นี้ก่อนทำ Phase ใหม่ทุกครั้ง

แต่ Codex:

**ห้ามแก้ Business Requirement สำคัญในไฟล์นี้เอง**

ถ้าพบ Requirement ใหม่หรือ Conflict:

ให้รายงาน

ไม่ให้เปลี่ยน Direction ของ Project โดยอัตโนมัติ

ผู้ที่มีสิทธิ์กำหนด Business Direction:

- User
- ChatGPT ในบทบาท Planning / Architecture ตามคำสั่งผู้ใช้

Codex มีหน้าที่ Implement

Work มีหน้าที่ Validate

---

# 43. Instruction Precedence

หาก Requirement ขัดกัน ให้ใช้ลำดับความสำคัญ:

1. Latest explicit instruction from User
2. Current Phase Requirement
3. PROJECT_OVERVIEW.md
4. Existing Implementation
5. Developer Assumption

ห้ามใช้ Existing Code เป็นเหตุผลในการละเลย Requirement ใหม่

---

# 44. Before Every Phase

Codex ต้อง:

1. Read `PROJECT_OVERVIEW.md`
2. Read Current Phase Requirement
3. Inspect Existing Project
4. Inspect Git Status
5. Understand Current Database
6. Understand Existing Tests
7. Identify Conflicts
8. Develop
9. Test
10. Document
11. Commit
12. Report Result

---

# 45. Do Not Overbuild

หลักสำคัญ:

**Do not implement future phases prematurely**

ถ้า Phase ปัจจุบันต้องการ Foundation:

อย่าสร้าง Automation ขนาดใหญ่

ถ้า Phase ปัจจุบันต้องการ Mock Data:

อย่าเชื่อม API จริงโดยไม่จำเป็น

ให้สร้าง Architecture ที่ต่อยอดได้

แต่ทำ Feature เท่าที่ Phase ต้องการ

---

# 46. Final Project Vision

ภาพปลายทางของระบบคือ:

```text
AFFILIATE CONTENT FACTORY

Find Products
      ↓
EXTRA COMM Filter
      ↓
Affiliate Link
      ↓
Product Images
      ↓
Opportunity Ranking
      ↓
Content Generation
      ↓
Image Pages
+
AI Video Pages
      ↓
Market Testing
      ↓
Performance Data
      ↓
Winner Detection
      ↓
Order Product
      ↓
Real Product Review
      ↓
Scale
      ↓
Learn
      ↓
Better Product Selection
      ↓
Repeat
```

เป้าหมายสูงสุด:

**เปลี่ยนการทำ Shopee Affiliate จากการเลือกสินค้าและทำ Content แบบเดาสุ่ม ให้กลายเป็นระบบที่ขับเคลื่อนด้วยข้อมูล การทดลอง และการเรียนรู้จากผลลัพธ์จริง**

---

# 47. Current Project Status

Current status:

**Project Planning**

Project directory created:

`D:\CodeX\AffiliateContent`

Next planned action:

**PHASE 0 — Project Bootstrap & Architecture**

ยังไม่เริ่ม Coding ระบบหลัก

---

# 48. Important Note for Codex

Before implementing anything:

Read this file completely.

This file defines the overall business context and project direction.

A Phase prompt will define exactly what should be implemented at that point.

Do not attempt to implement the entire project from this document.

Use this document to understand:

- WHY the system exists
- HOW the complete workflow should work
- WHAT architectural decisions must remain compatible with future phases

Then implement only the scope defined by the current Phase.