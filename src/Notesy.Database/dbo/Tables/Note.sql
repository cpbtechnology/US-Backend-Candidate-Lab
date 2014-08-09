CREATE TABLE [dbo].[Note] (
    [Id]          INT             IDENTITY (1, 1) NOT NULL,
    [Title]       NVARCHAR (512)  NULL,
    [Description] NVARCHAR (2048) NULL,
    [IsComplete]  BIT             CONSTRAINT [DF_Note_IsComplete] DEFAULT ((0)) NOT NULL,
    [ApiUserId]   INT             NOT NULL,
    [DateCreated] DATETIME        CONSTRAINT [DF_Note_DateCreated] DEFAULT (getutcdate()) NOT NULL,
    CONSTRAINT [PK_Note] PRIMARY KEY CLUSTERED ([Id] ASC),
    CONSTRAINT [FK_Note_ApiUser] FOREIGN KEY ([ApiUserId]) REFERENCES [dbo].[ApiUser] ([Id])
);

