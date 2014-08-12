CREATE TABLE [dbo].[ApiUser] (
    [Id]          INT             IDENTITY (1, 1) NOT NULL,
    [Name]        NVARCHAR (256)  NOT NULL,
    [ApiKey]      NVARCHAR (1024) NOT NULL,
    [ApiSecret]   NVARCHAR (1024) NOT NULL,
    [DateCreated] DATETIME        CONSTRAINT [DF_ApiUser_DateCreated] DEFAULT (getutcdate()) NOT NULL,
    CONSTRAINT [PK_ApiUser] PRIMARY KEY CLUSTERED ([Id] ASC)
);

